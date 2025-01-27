<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escola extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'telefone1',
        'telefone2',
        'endereco',
        'bairro',
        'municipio',
    ];

    public function modalidades()
    {
        return $this->belongsToMany(Modalidade::class);
    }

    public function quadroVagas()
    {
        return $this->hasMany(QuadroVaga::class);
    }

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'escola_id_1');
    }

    public function segundaOpcaoInscricoes()
    {
        return $this->hasMany(Inscricao::class, 'escola_id_2');
    }

    public function filasDeEspera()
    {
        return $this->hasMany(FilaEspera::class);
    }
}