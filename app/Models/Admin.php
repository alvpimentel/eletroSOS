<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    // Definir os campos que podem ser preenchidos
    protected $fillable = ['user_id'];

    /**
     * Relacionamento com o modelo User.
     * Um admin pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
