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
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();

            // Dados principais
            $table->string('titulo_tarefa', 255);
            $table->text('descricao_taf')->nullable();

            // Relações
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
            $table->foreignId('gestor_id')->nullable()->constrained('funcionarios')->onDelete('set null');

            // Gestão de prazos e nível
            $table->integer('dias_paraCompletar')->nullable();
            $table->date('data_limite')->nullable();
            $table->integer('numero_de_nivel')->default(1);

            // // Estado e importância
            // $table->enum('importancia_tarefa', ['Muito Alto', 'Alto', 'Média', 'Baixo', 'Muito Baixo'])->default('Média');
            // $table->enum('estado_tarefa', ['Pendente', 'Em Andamento', 'Concluída', 'Atrasada'])->default('Pendente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('tarefas');
        Schema::enableForeignKeyConstraints();
    }
};
