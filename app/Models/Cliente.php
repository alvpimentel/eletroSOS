<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'telefone', 'company_id', 'tipo_pessoa', 'cpf', 'cnpj', 'endereco', 'obs'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'company_id');
    }
}