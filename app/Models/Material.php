<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'qtd', 'idUsuario'];

    /**
     * Relacionamento com o usuário que criou o material.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    public function pertenceAoUsuario($userId)
    {
        return $this->idUsuario === $userId;
    }

}
