<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Escola;
use App\Models\Modalidade;

class EscolaModalidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtém todas as escolas e modalidades
        $escolas = Escola::all();
        $modalidades = Modalidade::all();

        // Associa modalidades a cada escola
        foreach ($escolas as $escola) {
            // Atribui de 1 a 3 modalidades aleatórias para cada escola
            $modalidadesParaAssociar = $modalidades->random(rand(1, 3));

            // Sincroniza as modalidades para a escola atual
            $escola->modalidades()->sync($modalidadesParaAssociar->pluck('id')->toArray());
        }
    }
}