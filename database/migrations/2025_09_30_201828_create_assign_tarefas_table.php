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
        Schema::create('assign_tarefas', function (Blueprint $table) {
            $table->id();

            // Relações principais
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
            $table->foreignId('gestor_id')->constrained('funcionarios')->onDelete('cascade'); // chefe/gestor
            $table->foreignId('funcionario_id')->constrained('funcionarios')->onDelete('cascade');
            $table->foreignId('tarefa_id')->constrained('tarefas')->onDelete('cascade');

            // Avaliação e métricas
            $table->decimal('resultado', 5, 2)->nullable(); // nota final atribuída
            $table->decimal('peso', 5, 2)->nullable();      // peso da tarefa no contexto da avaliação
            $table->boolean('gestor_peso_status')->default(false); // se o peso foi confirmado pelo gestor

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_tarefas');
    }
};
