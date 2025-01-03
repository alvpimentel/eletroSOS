<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Material;

class MaterialController extends Controller
{
    /**
     * Exibe a lista de materiais com suporte a pesquisa.
     */
    public function showMaterial(Request $request)
    {
        $query = Material::where('idUsuario', Auth::id());

        $materiais = $query->get();

        return view('material.index', compact('materiais'));
    }

    /**
     * Cria um novo material.
     */
    public function createMaterial(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'qtd' => 'required|integer|min:1',
        ]);

        Material::create([
            'nome' => $request->input('nome'),
            'qtd' => $request->input('qtd'),
            'idUsuario' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Material criado com sucesso!');
    }

    /**
     * Atualiza a quantidade de um material existente.
     */
    public function updateMaterial(Request $request, $id)
    {
        $request->validate([
            'qtd' => 'required|integer|min:1',
        ]);

        $material = Material::where('id', $id)
            ->where('idUsuario', Auth::id())
            ->firstOrFail();

        $material->update([
            'qtd' => $request->input('qtd'),
        ]);

        return redirect()->back()->with('success', 'Material atualizado com sucesso!');
    }
}
