<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; 
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    public function showClientes()
    {
        $clientes = Cliente::where('idUsuario', Auth::id())->get(); 
    
        return view('clientes.show_clientes', compact('clientes'));
    }    

    public function showCreateClientes()
    {
        return view('clientes.create_clientes');
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
            'idUsuario' => Auth::id(),
        ]);
    
        return redirect()->route('clientes')->with('success', 'Cliente criado com sucesso!');
    }
    
}
