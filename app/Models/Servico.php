<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

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
        'valor',
        'status',
        'statusPagamento'
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
     * Relacionamento: Um serviço pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
}
