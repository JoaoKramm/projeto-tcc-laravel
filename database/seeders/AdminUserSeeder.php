<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Importe o model User
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nome' => 'Administrador',
            'cpf' => '11122233344', // Use um CPF válido ou remova/comente essa linha se não for usar
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Defina uma senha forte!
            'data_nascimento' => '1990-01-01',  // Uma data qualquer
            'celular' => '51999999999',
            'tipo' => 'admin', // Defina o tipo como 'admin'
        ]);
    }
}