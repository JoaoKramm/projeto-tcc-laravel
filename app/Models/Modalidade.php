<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
    ];

    public function escolas()
    {
        return $this->belongsToMany(Escola::class);
    }

    public function quadroVagas()
    {
        return $this->hasMany(QuadroVaga::class);
    }
}