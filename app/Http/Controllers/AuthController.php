<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (Auth::attempt($credentials)) {
            if (!Auth::user()->status) {
                Auth::logout();
                
                return back()->withErrors([
                    'email' => 'Sua conta está desativada, entre em contato com o suporte.',
                ]);
            }
    
            $request->session()->regenerate();
    
            if (Auth::user()->is_admin) {
                return redirect()->intended('/admin/home'); 
            }
    
            return redirect()->intended('/painel'); 
        }
    
        return back()->withErrors([
            'email' => 'Login inválido.',
        ])->withInput($request->only('email'));
    }
    

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
    
        return redirect()->route('login'); 
    }
}