<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Servico extends Model
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

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'user_id',
        'cliente_id',
        'material_id',
        'nome',
        'descricao',
        'finalizado',
        'valor',
        'status',
        'prioridade_id',
        'dt_chamado',
        'statusPagamento',
        'tecnico_id',
    ];

    /**
     * Tipos de dados dos atributos.
     *
     * @var array
     */
    protected $casts = [
        'valor' => 'decimal:2',
        'status' => 'boolean',
        'statusPagamento' => 'boolean',
    ];

    /**
     * Relacionamento: Um serviço pertence a uma empresa.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relacionamento: O serviço foi criado por um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relacionamento: O serviço é de responsabilidade de um técnico.
     */
    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    /**
     * Relacionamento: Um serviço pertence a um cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relacionamento: Um serviço utiliza um material.
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Relacionamento: Um serviço pode ter sido editado por um usuário.
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'editado_por');
    }

    /**
     * Relacionamento: Um serviço pode ter uma prioridade.
     */
    public function prioridade()
    {
        return $this->belongsTo(Prioridade::class, 'prioridade_id');
    }
    
}
