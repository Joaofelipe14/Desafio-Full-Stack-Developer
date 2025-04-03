<?php

namespace App\Models;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cpf', 'email', 'birth_date','url_perfil', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}