<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteEmailLog extends Model
{
    protected $fillable = [
        'client_id',
        'type',
        'status',
        'sent_in'
    ];

    public function clients ()
    {
        return $this->belongsTo(Clients::class);
    }
}