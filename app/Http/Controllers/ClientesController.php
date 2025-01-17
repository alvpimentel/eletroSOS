<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; 
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    public function showClientes()
    {
        $clientes = Cliente::where('company_id', Auth::user()->company_id)->get();
    
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
    
        return view('clientes.edit_clientes', compact('cliente'));
    }
    

    public function createCliente(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes,email',
            'telefone' => 'nullable|string|max:15',
            'tipo_pessoa' => 'required|in:0,1', // Garante que o tipo seja 0 (física) ou 1 (jurídica)
            'cpf' => 'nullable|string|max:11',
            'cnpj' => 'nullable|string|max:14',
            'endereco' => 'nullable|string|max:255',
            'obs' => 'nullable|string',
        ]);
    
        // Validação condicional para CPF ou CNPJ
        if ($request->tipo_pessoa === "0" && !$request->cpf) {
            return redirect()->back()->withErrors(['cpf' => 'O CPF é obrigatório para pessoa física.'])->withInput();
        }
    
        if ($request->tipo_pessoa === "1" && !$request->cnpj) {
            return redirect()->back()->withErrors(['cnpj' => 'O CNPJ é obrigatório para pessoa jurídica.'])->withInput();
        }
    
        Cliente::create([
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
    
        return redirect()->route('clientes')->with('success', 'Cliente criado com sucesso!');
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
