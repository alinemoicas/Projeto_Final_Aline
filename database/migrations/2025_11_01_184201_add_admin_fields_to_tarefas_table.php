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
        Schema::table('tarefas', function (Blueprint $table) {
            // Campos novos (o teu form e controller já usam estes nomes)
            $table->unsignedBigInteger('departamento_id')->after('id');
            $table->unsignedBigInteger('gestor_id')->after('departamento_id');
            $table->integer('dias_para_completar')->after('gestor_id');
            $table->integer('numero_de_nivel')->after('dias_para_completar');
            $table->date('data_limite')->after('numero_de_nivel');

            // FKs (ajusta nomes das tabelas/PKs se forem diferentes)
            $table->foreign('departamento_id')->references('id')->on('departamentos')->cascadeOnDelete();
            $table->foreign('gestor_id')->references('id')->on('gestores')->cascadeOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropForeign(['departamento_id']);
            $table->dropForeign(['gestor_id']);
            $table->dropColumn(['departamento_id', 'gestor_id', 'dias_para_completar', 'numero_de_nivel', 'data_limite']);
        });
    }
};
