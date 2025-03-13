<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Resources\Payment;
use Illuminate\Support\Facades\Session;
use Exception;


class PagamentoController extends Controller
{
    public function showPix()
    {
        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
            $client = new PaymentClient();
    
            $payment = $client->create([
                "transaction_amount" => 50.00,
                "payment_method_id" => "pix",
                "description" => "Cadastro de Companhia",
                "payer" => [
                    "email" => "usuario@email.com",
                    "first_name" => "Usuário",
                    "last_name" => "Teste"
                ]
            ]);
    
            //dd($payment); // Isso mostra toda a resposta do Mercado Pago
    
            if ($payment->status == 'pending') {
                $qr_code = $payment->point_of_interaction->transaction_data->qr_code_base64 ?? null;
            
                if (!$qr_code) {
                    return redirect()->back()->with('error', 'Erro ao obter QR Code do pagamento.');
                }
            
                Session::put('pix_qr_code', $qr_code);
                Session::put('payment_id', $payment->id);
            
                return view('cadastro.companhia.index', compact('qr_code'));
            }
            
            //dd($payment->point_of_interaction);
    
            return redirect()->back()->with('error', 'Erro ao gerar QR Code.');
        } catch (\Exception $e) {
            dd('Erro no pagamento: ' . $e->getMessage());
        }
    }
    

    public function confirmarPagamento(Request $request)
    {
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));
        $client = new PaymentClient();

        $paymentId = Session::get('payment_id');

        try {
            $payment = $client->get($paymentId);

            if ($payment && $payment->status == 'approved') {
                Session::put('payment_verified', true);
                return redirect()->route('companies.create');
            }

            return redirect()->back()->with('error', 'Pagamento não confirmado.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao verificar pagamento: ' . $e->getMessage());
        }
    }
}
