<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;

class UserController extends Controller
{
    public function showUsuarios()
    {
        $usuarios = User::with('admin')->get();
    
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function showCreateUsuario()
    {
        return view('admin.usuarios.create'); 
    }

    public function showCadastroForm()
    {
        return view('cadastro.usuario.index'); 
    }

    public function getAllUsuarios()
    {
        $usuarios = User::whereDoesntHave('admin')->get();

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function createUsuario(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Verifica se o checkbox de administrador está marcado
        if ($request->has('is_admin') && $request->input('is_admin') == '1') {
            Admin::create(['user_id' => $user->id]); // Relaciona o usuário à tabela admins
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function createUsuarioCadastro(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'company_id' => 'required|integer',
        ]);

        // Pega o company_id da sessão
        $companyId = session('company_id');

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'status' => 1,
            'company_id' => $companyId
        ]);

        return redirect()->route('login')->with('success', 'Usuário criado com sucesso!');
    }
}
