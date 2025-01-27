<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prioridade extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'peso',
        'ativa',
        'cidade',
    ];

    protected $primaryKey = 'id_prioridade';
}