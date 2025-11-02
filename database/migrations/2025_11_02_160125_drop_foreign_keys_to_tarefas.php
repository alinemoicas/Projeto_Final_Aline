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
        Schema::table('assign_tarefas', function (Blueprint $table) {
            // Laravel >= 9: remove a FK + coluna de uma vez
            // $table->dropConstrainedForeignId('tarefa_id');

            // Alternativa compatível (Laravel 8+):
            $table->dropForeign(['tarefa_id']); // remove a constraint
            // Se quiser manter a coluna, deixe como está.
            // Se quiser remover a coluna também:
            // $table->dropColumn('tarefa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assign_tarefas', function (Blueprint $table) {
            // Recrie a coluna se a removeu no up()
            // $table->foreignId('tarefa_id')->constrained('tarefas')->cascadeOnDelete();

            // Se a coluna ficou, basta voltar a pôr a FK:
            $table->foreign('tarefa_id')->references('id')->on('tarefas')->cascadeOnDelete();
        });
    }
};
