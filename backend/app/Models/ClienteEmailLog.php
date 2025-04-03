<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteEmailLog extends Model
{
    protected $fillable = [
        'cliente_id',
        'tipo',
        'status',
        'enviado_em'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}