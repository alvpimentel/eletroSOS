<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrato;
use App\Models\Servico;

class ContratoController extends Controller
{
    public function showContratos($id)
    {
        $contratos = Contrato::where('servico_id', $id)
            ->where('status', 1)
            ->orderByDesc('dt_criacao')
            ->paginate(10);

        return view('servicos.edit', compact('contratos'));
    }

    public function buildContrato($id)
    {
        $servico = Servico::where('id', $id)->firstOrFail();
        
        return view('contratos.index', compact('servico'));
    }
}

