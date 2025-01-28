<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuadroVaga;
use App\Models\Escola;
use App\Models\Modalidade;

class QuadroVagasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $escolas = Escola::all();
        $turnos = ['Manhã', 'Tarde', 'Integral'];

        foreach ($escolas as $escola) {
            //Pega as modalidades da escola
            $modalidades = $escola->modalidades;

            foreach ($modalidades as $modalidade) {
                foreach ($turnos as $turno) {
                    QuadroVaga::create([
                        'escola_id' => $escola->id,
                        'modalidade_id' => $modalidade->id,
                        'turno' => $turno,
                        'vagas' => rand(5, 20), // Número aleatório de vagas entre 5 e 20
                        'vagas_ocupadas' => 0,
                        'prioridade_ativa' => false, // Defina como true se a prioridade estiver ativa
                    ]);
                }
            }
        }
    }
}