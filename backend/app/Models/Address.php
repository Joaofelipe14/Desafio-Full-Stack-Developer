<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'address';

    protected $fillable = ['address', 'neighborhood','city_id'];

    public function city()
    {
        return $this->belongsTo(Cities::class);
    }

    public function clients()
    {
        return $this->hasMany(Clients::class);
    }
}
