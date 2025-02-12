<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Contrato extends Model
{
    use HasFactory;

    /**
     * Tornar padrao filtro por companhia em todas as buscas
     */
    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('company_id', Auth::user()->company_id);
            }
        });
    }

    protected $fillable = [
        'company_id', 
        'user_id', 
        'cliente_id', 
        'servico_id', 
        'nr_versao', 
        'tx_contrato', 
        'dt_criacao', 
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'dt_criacao' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class);
    }
}
