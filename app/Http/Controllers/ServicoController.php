<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Servico;
use App\Models\Cliente;
use App\Models\Material;
use App\Models\Prioridade;
use Carbon\Carbon;
use Error;

class ServicoController extends Controller
{
    public function showServicos(Request $request)
    {
        $servicos = Servico::where('status', 1)->
        orderByDesc('dt_chamado')->
        paginate(10);

        return view('servicos.index', compact('servicos'));
    }

    public function showCreateServico()
    {
        $clientes = Cliente::where('company_id', Auth::user()->company_id)->get();;
        $materiais = Material::where('company_id', Auth::user()->company_id)->get();;
        $prioridades = Prioridade::all();

        return view('servicos.create', compact('clientes', 'materiais', 'prioridades'));
    }

    public function createServico(Request $request)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'descricao' => 'required|string',
                'valor' => 'required|numeric|min:0',
                'cliente_id' => 'required|exists:clientes,id', 
                'material_id' => 'required|exists:materials,id', 
            ]);
        
            $servico = new Servico();
            $servico->company_id = Auth::user()->company_id; 
            $servico->user_id = Auth::id(); 
            $servico->cliente_id = $request->cliente_id;
            $servico->material_id = $request->material_id;
            $servico->nome = $request->nome;
            $servico->descricao = $request->descricao;
            $servico->valor = $request->valor;
            $servico->dt_chamado = $request->dt_chamado;
            $servico->save(); 
        
            return redirect()->route('servicos')->with('success', 'Serviço criado com sucesso!');
        
        } catch (\Exception $e) {
            
            return redirect()->route('servicos')->with('error', 'Não foi possível criar o serviço. Erro: ' . $e->getMessage());
            
        }
    }

    public function showEditServico($id)
    {
        $servico = Servico::where('id', $id)->firstOrFail(); 
    
        return view('servicos.edit', compact('servico'));
    }

    public function editServico(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'valor' => 'required|string',
        ]);

        $valorFormatado = str_replace(['R$', '.', ','], ['', '', '.'], $request->valor);

        $servico = Servico::findOrFail($id);
        $servico->nome = $request->nome;
        $servico->descricao = $request->descricao;
        $servico->valor = number_format((float) $valorFormatado, 2, '.', '');
        $servico->editado_por = Auth::id();
        $servico->dt_chamado = $request->dt_chamado;
        $servico->finalizado = $request->finalizado;
        $servico->statusPagamento = $request->statusPagamento;
        $servico->save(); 

        return redirect()->route('servicos')->with('success', 'Serviço atualizado com sucesso!');
    
    }


    public function dashboard()
    {
        $hoje = Carbon::today();

        $servicosAbertos = Servico::where('finalizado', 0)->count();
        $servicosFechados = Servico::where('finalizado', 1)->count();
        $servicosPraHoje = Servico::whereDate('dt_chamado', $hoje)->count();
    
        return view('painel.index', compact('servicosAbertos', 'servicosFechados', 'servicosPraHoje'));
    }
}
