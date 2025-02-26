<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contrato;
use App\Models\Servico;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\LogHelper;

class ContratoController extends Controller
{
    public function showContratos($id)
    {
        $contratos = Contrato::where('servico_id', $id)
            ->paginate(10);

        return view('contratos.index', compact('contratos'));
    }

    public function buildContrato($id)
    {
        $servico = Servico::where('id', $id)->firstOrFail();
        
        return view('contratos.show', compact('servico'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'company_id'  => 'required|exists:companies,id',
                'user_id'     => 'required|exists:users,id',
                'cliente_id'  => 'required|exists:clientes,id',
                'servico_id'  => 'required|exists:servicos,id',
                'tx_contrato' => 'required|string',
            ]);
    
            $contratoAnterior = Contrato::where('servico_id', $request->servico_id)
                                        ->orderBy('nr_versao', 'desc')
                                        ->first();
    
            if ($contratoAnterior) {
                // Atualizar status do contrato anterior para inativo (0)
                $contratoAnterior->update(['status' => 0]);
            }
    
            // Definir número da versão
            $nrVersao = ($contratoAnterior ? $contratoAnterior->nr_versao : 0) + 1;
    
            $contrato = Contrato::create([
                'company_id'  => $request->company_id,
                'user_id'     => $request->user_id,
                'cliente_id'  => $request->cliente_id,
                'servico_id'  => $request->servico_id,
                'nr_versao'   => $nrVersao,
                'tx_contrato' => $request->tx_contrato,
                'status'      => 1,
            ]);

            LogHelper::registrar('Contrato criado', request()->ip(), [
                'contrato_id' => $contrato->id,
                'servico_id' => $request->servico_id,
                'cliente_id' => $request->cliente_id,
                'nr_versao' => $nrVersao,
            ]);
    
            return response()->json(['success' => true, 'message' => 'Contrato gerado!']);
    
        } catch (\Throwable $e) { 
            return redirect()
                ->route('contratos.index')
                ->with('error', 'Erro ao criar o contrato: ' . $e->getMessage());
        }
    }    

    public function downloadPdf($id)
    {
        try{
            $contrato = Contrato::findOrFail($id);
        
            // Verifica se HTML do contrato existe no banco
            if (!$contrato->tx_contrato) {
                return back()->with('error', 'Contrato sem conteúdo para gerar PDF.');
            }
    
            $pdf = Pdf::loadHTML($contrato->tx_contrato);
    
            return $pdf->download("Contrato_{$contrato->servico->nome}_{$contrato->nr_versao}.pdf");

        } catch (\Throwable $e) { 
            return redirect()
                ->route('contratos.index')
                ->with('error', 'Erro ao gerar PDF do contrato: ' . $e->getMessage());
        }
    }

}

