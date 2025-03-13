<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; 
use App\Models\Servico; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogHelper;

class ClientesController extends Controller
{
    public function showClientes()
    {
        $clientes = Cliente::where('company_id', Auth::user()->company_id)->
        paginate(10);
    
        return view('clientes.index', compact('clientes'));
    }    

    public function showCreateClientes()
    {
        return view('clientes.create_clientes');
    }

    public function showEditClientes($id)
    {
        $cliente = Cliente::where('id', $id)
            ->where('company_id', Auth::user()->company_id) 
            ->firstOrFail(); 

            $servicos = Servico::where('cliente_id', $id)
            ->where('company_id', Auth::user()->company_id)
            ->where('status', 1)
            ->paginate(10);
    
        return view('clientes.edit_clientes', compact('cliente', 'servicos'));
    }

    public function createCliente(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'nullable|string|max:15',
            'tipo_pessoa' => 'required|in:0,1',
            'cpf' => 'nullable|string|max:11',
            'cnpj' => 'nullable|string|max:14',
            'endereco' => 'nullable|string|max:255',
            'obs' => 'nullable|string',
        ]);
    
        if ($request->tipo_pessoa === "0" && !$request->cpf) {
            return redirect()->back()->withErrors(['cpf' => 'O CPF é obrigatório para pessoa física.'])->withInput();
        }
    
        if ($request->tipo_pessoa === "1" && !$request->cnpj) {
            return redirect()->back()->withErrors(['cnpj' => 'O CNPJ é obrigatório para pessoa jurídica.'])->withInput();
        }
    
        try {
            $cliente = Cliente::create([
                'nome' => $request->input('nome'),
                'email' => $request->input('email'),
                'telefone' => $request->input('telefone'),
                'tipo_pessoa' => $request->input('tipo_pessoa'),
                'cpf' => $request->input('cpf'),
                'cnpj' => $request->input('cnpj'),
                'endereco' => $request->input('endereco'),
                'obs' => $request->input('obs'),
                'company_id' => Auth::user()->company_id,
            ]);
    
            LogHelper::registrar('Cliente criado', request()->ip(), [
                'cliente_id' => $cliente->id,
                'nome' => $cliente->nome,
                'email' => $cliente->email,
            ]);
    
            return redirect()->route('clientes')->with('success', 'Cliente criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao criar o cliente.'])->withInput();
        }
    }

    public function updateCliente(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
    
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'nullable|string|max:15',
            'endereco' => 'nullable|string|max:255',
            'obs' => 'nullable|string',
        ]);
    
        $cliente->update([
            'nome' => $request->input('nome'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
            'endereco' => $request->input('endereco'),
            'obs' => $request->input('obs'),
        ]);
    
        return redirect()->route('clientes')->with('success', 'Cliente atualizado com sucesso!');
    }
    

    
}
