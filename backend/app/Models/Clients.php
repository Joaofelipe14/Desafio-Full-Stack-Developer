<?php

namespace App\Models;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mobile', 'email', 'birth_date','url_perfil', 'address_id'];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}