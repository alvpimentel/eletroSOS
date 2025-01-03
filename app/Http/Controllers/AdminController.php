<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class AdminController extends Controller
{
    public function showAdmin()
    {
        return view('admin.index');
    }

    public function countUsuarios()
    {
        $usuariosSemAdmin = User::whereDoesntHave('admin')->where('status', 1)->count();

        return view('admin.index', compact('usuariosSemAdmin'));
    }
}
