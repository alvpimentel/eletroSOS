<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckNivel
{
    /**
     * Handle an incoming request.
     * Tem como parametro o nivel a ser checado
     */
    public function handle(Request $request, Closure $next, $nivel)
    {
        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($user->nivel_id != $nivel) {
            abort(403, 'Acesso negado.');
        }

        return $next($request);
    }
}
