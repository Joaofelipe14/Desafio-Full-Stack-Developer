<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteEmailLog extends Model
{
    protected $fillable = [
        'customer_id',
        'type',
        'status',
        'sent_in'
    ];

    public function customers()
    {
        return $this->belongsTo(customers::class);
    }
}