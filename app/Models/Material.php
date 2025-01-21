<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'qtd', 'valor', 'company_id'];

    /**
     * Relacionamento com a companhia que criou o material.
     */
    public function company()
    {
        return $this->belongsTo(User::class, 'company_id', 'id');
    }    

    public function pertenceAoUsuario($userId)
    {
        return $this->company_id === $userId;
    }

}
