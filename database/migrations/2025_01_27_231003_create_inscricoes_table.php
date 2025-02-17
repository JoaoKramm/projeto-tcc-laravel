<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('escola_id_1')->constrained('escolas')->onDelete('cascade');
            $table->foreignId('escola_id_2')->nullable()->constrained('escolas')->onDelete('cascade');
            
            // FK para 'quadro_vagas', permitindo valor nulo e ajustando onDelete se preferir
            $table->foreignId('quadro_vaga_id')->nullable()->constrained('quadro_vagas')->onDelete('set null');

            $table->enum('status', ['Inscrito', 'Fila de Espera', 'Deferido', 'Indeferido'])->default('Deferido');
            $table->date('data_inscricao');

            // Removido: $table->text('observacoes')->nullable();

            // Dados da criança e do responsável
            $table->string('nome_crianca');
            $table->date('data_nascimento_crianca');
            $table->string('nome_responsavel');
            $table->string('cpf_responsavel', 11);
            $table->string('cep_responsavel');
            $table->string('endereco_responsavel');
            $table->string('numero_casa_responsavel');
            $table->string('bairro_responsavel');

            // Caminhos dos arquivos
            $table->string('certidao_nascimento_path');
            $table->string('comprovante_residencia_path');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricoes');
    }
};
