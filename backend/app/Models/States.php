<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'uf'];

    public function citys()
    {
        return $this->hasMany(Cities::class);
    }
}
