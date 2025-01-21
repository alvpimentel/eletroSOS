<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Servico;
use Error;

class ServicoController extends Controller
{
    public function showServicos(Request $request)
    {
        $servicos = Servico::where('company_id', Auth::user()->company_id)->get();

        return view('servicos.index', compact('servicos'));
    }

    public function showCreateServico()
    {
        return view('servicos.create');
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
            $servico->save(); 
        
            return redirect()->route('servicos.index')->with('success', 'Serviço criado com sucesso!');
        
        } catch (\Exception $e) {
            
            return redirect()->route('servicos.index')->with('error', 'Não foi possível criar o serviço. Erro: ' . $e->getMessage());
            
        }
    }
}
