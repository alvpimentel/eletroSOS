<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function registrar(string $acao, string $ip ,array $detalhes = [])
    {
        Log::create([
            'user_id' => Auth::id(),
            'company_id' => Auth::user()->company_id, 
            'tx_acao' => $acao,
            'tx_ip' => $ip,
            'json_detalhes' => $detalhes,
        ]);
    }
}
