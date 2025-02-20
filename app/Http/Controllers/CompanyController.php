<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function showCompanyForm()
    {
        return view('cadastro.companhia.index');
    }

    /**
     * Armazena uma nova companhia no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cnpj' => 'required|string|unique:companies|max:14',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $validated['status'] = 1;

        $company = Company::create($validated);

        session()->put('company_id', $company->id);

        return redirect()->route('cadastro.usuario');
    } 

}

