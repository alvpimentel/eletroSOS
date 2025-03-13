<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicoLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'servico_id',
        'tx_alteracoes',
        'json_detalhes',
        'tx_ip',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Relação com o model User (um log pertence a um usuário)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relação com o model Servico (um log pertence a um serviço)
    public function servico()
    {
        return $this->belongsTo(Servico::class, 'servico_id');
    }
}
