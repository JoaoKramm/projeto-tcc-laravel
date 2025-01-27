<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilaEspera extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscricao_id',
        'escola_id',
        'modalidade',
        'turno',
        'posicao',
        'chamado',
        'prioridade'
    ];

    public function inscricao()
    {
        return $this->belongsTo(Inscricao::class);
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }
}