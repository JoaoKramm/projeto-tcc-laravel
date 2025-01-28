<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Escola;

class EscolasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Escola::create([
            'nome' => 'Escola Municipal de Educação Infantil Cypriano José Centeno',
            'telefone1' => '(51) 9999-9999',
            'telefone2' => '(51) 8888-8888',
            'endereco' => 'Rua Exemplo, 123',
            'bairro' => 'Centro',
            'municipio' => 'Camaquã',
        ]);

        Escola::create([
            'nome' => 'Escola Municipal de Educação Infantil Irmas Bernardinas',
            'telefone1' => '(51) 9999-9999',
            'telefone2' => '(51) 8888-8888',
            'endereco' => 'Rua das Irmãs, 456',
            'bairro' => 'Santa Marta',
            'municipio' => 'Camaquã',
        ]);
        Escola::create([
            'nome' => 'Escola Municipal de Educação Infantil Mimosa',
            'telefone1' => '(51) 9999-9999',
            'telefone2' => '(51) 8888-8888',
            'endereco' => 'Rua das Flores, 789',
            'bairro' => 'Jardim das Acácias',
            'municipio' => 'Camaquã',
        ]);
    
        Escola::create([
            'nome' => 'Escola Municipal de Educação Infantil Nossa Senhora Aparecida',
            'telefone1' => '(51) 9999-9999',
            'telefone2' => '(51) 8888-8888',
            'endereco' => 'Rua da Padroeira, 101',
            'bairro' => 'Dona Tereza',
            'municipio' => 'Camaquã',
        ]);
    
        Escola::create([
            'nome' => 'Escola Municipal Ed Infa Cecy Ribeiro Dias',
            'telefone1' => '(51) 9999-9999',
            'telefone2' => '(51) 8888-8888',
            'endereco' => 'Rua Cecy Ribeiro, 202',
            'bairro' => 'Getulio Vargas',
            'municipio' => 'Camaquã',
        ]);
    
        Escola::create([
            'nome' => 'Escola Municipal de Educação Infantil Barbosa Lessa',
            'telefone1' => '(51) 9999-9999',
            'telefone2' => '(51) 8888-8888',
            'endereco' => 'Rua Barbosa Lessa, 303',
            'bairro' => 'Viegas',
            'municipio' => 'Camaquã',
        ]);
        Escola::create([
            'nome' => 'Escola Municipal de Educação Infantil Irmaos Maristas',
            'telefone1' => '(51) 9999-9999',
            'telefone2' => '(51) 8888-8888',
            'endereco' => 'Rua dos Irmãos, 303',
            'bairro' => 'Conego Luiz Walter Hanquet',
            'municipio' => 'Camaquã',
        ]);
        Escola::create([
            'nome' => 'Escola Municipal de Educação Infantil Recanto Infantil',
            'telefone1' => '(51) 9999-9999',
            'telefone2' => '(51) 8888-8888',
            'endereco' => 'Rua Recanto, 303',
            'bairro' => 'Bom Sucesso',
            'municipio' => 'Camaquã',
        ]);
    }
}