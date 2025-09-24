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
            $table->text('descricao_taf');
            $table->unsignedBigInteger('funcionario_id');
            $table->string('titulo_taf');
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->string('importancia_taref')->default('Alta');
            $table->string('estado_tarefa')->nullable();
            $table->unsignedBigInteger('avaliacao_id')->nullable();
            #$table->timestamps();

            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->cascadeOnDelete();
            $table->foreign('avaliacao_id')->references('id')->on('avaliacao')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
