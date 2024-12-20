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
        ]);

        Cliente::create([
            'nome' => $request->input('nome'),
            'email' => $request->input('email'),
            'telefone' => $request->input('telefone'),
            'idUsuario' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Cliente criado com sucesso!');
    }

}
