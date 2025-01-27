<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuadroVaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'escola_id',
        'modalidade_id',
        'turno',
        'vagas',
        'vagas_ocupadas',
        'prioridade_ativa'
    ];

    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class);
    }

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class);
    }
}