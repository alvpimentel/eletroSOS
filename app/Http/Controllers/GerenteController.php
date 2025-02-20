<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class GerenteController extends Controller
{
    /**
     * Lista usuários da companhia
     */
    public function showUsersCompany()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado.');
        }
    
        $companyId = Auth::user()->company_id;
        $companyInfo = Company::find($companyId);
        $usersCompany = User::where('company_id', $companyId)->orderBy('acesso_id', 'asc')->get();
    
        return view('gerente.index', compact('companyInfo', 'usersCompany'));
    }

    /**
     * Logo da companhia
     */   
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $company = Company::find(Auth::user()->company_id);
    
        if ($company) {
            $logoBase64 = base64_encode(file_get_contents($request->file('logo')->path()));
            $company->tx_logo = $logoBase64;
            $company->save();
        }
    
        return redirect()->back()->with('success', 'Logo atualizada com sucesso!');
    }

    public function showLogUser($userId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado.');
        }
    
        $logUsuario = Log::where('user_id', $userId)->with('user')->get();
    
        return view('gerente.logUsuario', compact('logUsuario'));
    }
    
}
