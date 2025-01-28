<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Modalidade;

class ModalidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Modalidade::create(['nome' => 'Berçário']);
        Modalidade::create(['nome' => 'Creche']);
        Modalidade::create(['nome' => 'Pré-escola']);
    }
}