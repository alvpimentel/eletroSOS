<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareAuthenticatedUser
{
    public function handle(Request $request, Closure $next)
    {
        View::share('usuario', Auth::user());

        return $next($request);
    }
}
