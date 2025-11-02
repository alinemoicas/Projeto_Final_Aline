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
        // Evita erro "Base table or view already exists"
        if (Schema::hasTable('funcionarios')) {
            // Se precisares de acrescentar colunas no futuro, cria uma migração "alter"
            // e usa Schema::table('funcionarios', fn(Blueprint $t) => ... );
            return;
        }

        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();

            // FKs corretas + nullOnDelete
            $table->foreignId('cargo_id')->nullable()->constrained('cargos')->nullOnDelete();
            $table->foreignId('dept_id')->nullable()->constrained('departamentos')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->date('data_admissao')->nullable();

            // Self-FK para chefe
            $table->foreignId('chefe_id')->nullable()->constrained('funcionarios')->nullOnDelete();

            $table->string('categoria')->nullable();
            $table->string('estado')->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
