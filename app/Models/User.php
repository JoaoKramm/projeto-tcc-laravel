<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cpf',
        'nome',
        'email',
        'password',
        'celular',
        'data_nascimento',
        'tipo', // Adicionado para diferenciar tipos de usuário
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Adicionando o relacionamento com Inscricao
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class);
    }
}