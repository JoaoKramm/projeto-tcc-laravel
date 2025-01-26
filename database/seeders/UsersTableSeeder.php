<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'cpf' => '12345678900',
            'nome' => 'Pedro Silva',
            'email' => 'pedro@gmail.com',
            'password' => Hash::make('senha123'), // Agora é 'password'
            'celular' => '51999999999',
            'data_nascimento' => '2000-01-01',
        ]);

        User::create([
            'cpf' => '12345678911',
            'nome' => 'Joao Silva',
            'email' => 'joao@gmail.com',
            'password' => Hash::make('12345'), // Agora é 'password'
            'celular' => '51999999999',
            'data_nascimento' => '2000-01-01',
        ]);
    }
}