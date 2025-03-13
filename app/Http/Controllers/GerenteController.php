<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Hash;
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
    
    public function updatePasswordForUser(Request $request, User $user)
    {
        try {

            if (Auth::user()->acesso_id != 1) {
                return response()->json([
                    'error' => 'Você não tem permissão para alterar a senha de outro usuário.',
                    'code' => 403
                ], 403);
            }
    
            $validatedData = $request->validate([
                'password' => 'required|min:6|confirmed',
            ]);
    
            $user->update([
                'password' => Hash::make($validatedData['password']),
            ]);
    
            return response()->json([
                'success' => 'Senha alterada com sucesso.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao alterar a senha.',
                'details' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    public function createUsuarioGerente(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'acesso_id' => 'required|integer|exists:niveis_acesso,id',
        ]);
    
        try {
            User::create([
                'company_id' =>Auth::user()->company_id,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'acesso_id' => $request->input('acesso_id'),
            ]);
    
            return redirect()->with('success', 'Usuário criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar usuário. Tente novamente.');
        }
    }    

}
