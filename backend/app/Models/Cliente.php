<?php

namespace App\Models;

use App\Models\Cidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cpf', 'email', 'data_nascimento', 'cidade_id'];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }
}