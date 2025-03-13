<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Servico;
use App\Models\ServicoLog;
use App\Models\Cliente;
use App\Models\Material;
use App\Models\User;
use App\Models\Prioridade;
use App\Models\Contrato;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use Mockery\Undefined;

class ServicoController extends Controller
{

    public function showServicos(Request $request)
    {
        $query = Servico::where('company_id', Auth::user()->company_id);
    
        // Filtros existentes (cliente, técnico, datas)
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }
        
        if ($request->filled('tecnico_id')) {
            $query->where('tecnico_id', $request->tecnico_id);
        }
    
        if ($request->filled('dataInicial') && $request->filled('dataFinal')) {
            $query->whereBetween('dt_chamado', [$request->dataInicial, $request->dataFinal]);
        } elseif ($request->filled('dataInicial')) {
            $query->whereDate('dt_chamado', '>=', $request->dataInicial);
        } elseif ($request->filled('dataFinal')) {
            $query->whereDate('dt_chamado', '<=', $request->dataFinal);
        }
    
        if ($request->filled('finalizado')) {
            $query->where('finalizado', $request->finalizado);
        }
    
        // Filtros do painel
        if ($request->filled('filtro')) {
            switch ($request->filtro) {
                case 'hoje':
                    $query->whereDate('data_atendimento', today());
                    break;
                case 'atrasadas':
                    $query->where('status', '!=', 'Fechado')->where('data_atendimento', '<', today());
                    break;
                case 'abertas':
                    $query->where('status', 'Aberto');
                    break;
                case 'fechadas':
                    $query->where('status', 'Fechado');
                    break;
            }
        }
    
        $servicos = $query->orderByDesc('dt_chamado')->paginate(10);
        $tecnicos = User::where('company_id', Auth::user()->company_id)->get();
        $clientes = Cliente::where('company_id', Auth::user()->company_id)->get();
    
        return view('servicos.index', compact('servicos', 'tecnicos', 'clientes'));
    }
     

    public function showCreateServico()
    {
        $clientes = Cliente::where('company_id', Auth::user()->company_id)->get();;
        $materiais = Material::where('company_id', Auth::user()->company_id)->get();;
        $prioridades = Prioridade::all();
        $tecnicos = User::where('company_id', Auth::user()->company_id)->get();

        return view('servicos.create', compact('clientes', 'materiais', 'prioridades', 'tecnicos'));
    }

    public function createServico(Request $request)
    {
        try {
            // Validação dos dados
             $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'required|string',
                'valor' => 'required|min:0',
                'cliente_id' => 'required|exists:clientes,id',
                'dt_chamado' => 'required|date',
                'prioridade_id' => 'required|exists:prioridades,id',
            ]);

            $valorFormatado = str_replace(['R$', '.', ','], ['', '', '.'], $request->valor);
            $valorFormatado = (float) $valorFormatado;

            // Criando o serviço
            $servico = new Servico();
            $servico->company_id = Auth::user()->company_id;
            $servico->user_id = Auth::id();
            $servico->cliente_id = $request->cliente_id;
            $servico->material_id = 1;
            $servico->nome = $request->nome;
            $servico->descricao = $request->descricao;
            $servico->valor = $valorFormatado;
            $servico->dt_chamado = $request->dt_chamado;
            $servico->prioridade_id = $request->prioridade_id;
            $servico->finalizado = 0;
            $servico->status = 1;
            $servico->statusPagamento = 0;
            $servico->tecnico_id = $request->tecnico_id;

            $servico->save();

            ServicoLog::create([
                'servico_id' => $servico->id,
                'user_id' => Auth::id(),
                'tx_alteracoes' => 'Criação do serviço',
                'json_detalhes' => json_encode($servico->toArray()),
                'tx_ip' => $request->ip(),
            ]); 

            return redirect()->route('servicos')->with('success', 'Serviço criado com sucesso!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('servicos')->with('error', 'Não foi possível criar o serviço. Erro: ' . $e->getMessage());
        }
    }
      

    public function showEditServico($id)
    {
        $servico = Servico::findOrFail($id); 
        
        $contratos = Contrato::where('servico_id', $id)
            ->orderByDesc('dt_criacao')
            ->paginate(10);
        
        $tecnicos = User::where('company_id', Auth::user()->company_id)->get();

        return view('servicos.edit', compact('servico', 'contratos', 'tecnicos'));
    }
    

    public function editServico(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'valor' => 'required|string',
        ]);
    
        $valorFormatado = str_replace(['R$', '.', ','], ['', '', '.'], $request->valor);
    
        // Verifica se tecnico_id é 0 e define como null
        $tecnicoId = $request->tecnico_id == 0 ? null : $request->tecnico_id;
    
        // Recupera o serviço antes da atualização
        $servico = Servico::findOrFail($id);
        $dadosAntigos = $servico->toArray(); // Valores antigos
    
        // Atualiza o serviço
        $servico->nome = $request->nome;
        $servico->descricao = $request->descricao;
        $servico->valor = number_format((float) $valorFormatado, 2, '.', '');
        $servico->editado_por = Auth::id();
        $servico->dt_chamado = $request->dt_chamado;
        $servico->finalizado = $request->finalizado;
        $servico->statusPagamento = $request->statusPagamento;
        $servico->tecnico_id = $tecnicoId;
        $servico->save();
    
        $dadosNovos = $servico->toArray();
    
        $alteracoes = [];
        foreach ($dadosNovos as $campo => $valorNovo) {
            if ($dadosAntigos[$campo] != $valorNovo) {
                $alteracoes[$campo] = [
                    'antigo' => $dadosAntigos[$campo],
                    'novo' => $valorNovo,
                ];
            }
        }
    
        // Salva o log apenas se houver alterações
        if (!empty($alteracoes)) {
            ServicoLog::create([
                'servico_id' => $servico->id,
                'user_id' => Auth::id(),
                'tx_alteracoes' => 'Editou serviço',
                'json_detalhes' => json_encode($alteracoes),
                'tx_ip' => $request->ip(),
            ]);
        }
    
        return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso!');
    }

    public function showServicoLogs(Servico $servico)
    {
        $servicosLog = ServicoLog::where('servico_id', $servico->id)
        ->orderByDesc('created_at')
        ->get();
    
        return view('servicos.log', compact('servicosLog', 'servico'));
    }


    public function dashboard()
    {
        $hoje = Carbon::today();
        
        $servicosAbertos = Servico::where('finalizado', 0)->count();
        $servicosFechados = Servico::where('finalizado', 1)->count();
        $servicosPraHoje = Servico::whereDate('dt_chamado', $hoje)->count();
        $servicosAtrasados = Servico::whereDate('dt_chamado', '<', $hoje)->count();
        
        $servicosPorDia = [];
        for ($dia = 1; $dia <= Carbon::now()->daysInMonth; $dia++) {
            $data = Carbon::createFromDate(null, Carbon::now()->month, $dia)->format('Y-m-d');
            $servicosPorDia[] = Servico::whereDate('dt_chamado', $data)->count();
        }
        
        return view('painel.index', compact('servicosAbertos', 'servicosFechados', 'servicosPraHoje', 'servicosAtrasados', 'servicosPorDia'));
    }  

}
