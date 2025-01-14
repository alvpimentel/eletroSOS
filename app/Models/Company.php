<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'description',
        'cnpj',
        'email',
        'phone',
        'address',
        'status',
    ];
}
