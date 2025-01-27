<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'escola_id_1',
        'escola_id_2',
        'quadro_vaga_id',
        'status',
        'data_inscricao',
        'observacoes',
        'nome_crianca',
        'data_nascimento_crianca',
        'nome_responsavel',
        'cpf_responsavel',
        'cep_responsavel',
        'endereco_responsavel',
        'numero_casa_responsavel',
        'bairro_responsavel',
        'certidao_nascimento_path',
        'comprovante_residencia_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function primeiraOpcaoEscola()
    {
        return $this->belongsTo(Escola::class, 'escola_id_1');
    }

    public function segundaOpcaoEscola()
    {
        return $this->belongsTo(Escola::class, 'escola_id_2');
    }

    public function quadroVaga()
    {
        return $this->belongsTo(QuadroVaga::class);
    }
    public function filaEspera()
    {
        return $this->hasOne(FilaEspera::class);
    }
}