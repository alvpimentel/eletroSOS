<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_id', 'tx_acao', 'tx_ip', 'json_detalhes'];

    protected $casts = [
        'json_detalhes' => 'array',
    ];

    /**
     * Define a relação entre User e LOG.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
