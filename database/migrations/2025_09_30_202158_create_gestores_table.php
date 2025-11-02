<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gestores', function (Blueprint $table) {
            $table->id();

            // 🔗 Ligação com tabela users
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // Se o user for removido, o gestor também

            // 🔗 Relações hierárquicas e departamentais
            $table->foreignId('departamento_id')
                ->nullable()
                ->constrained('departamentos')
                ->onDelete('set null');

            $table->foreignId('cargo_id')
                ->nullable()
                ->constrained('cargos')
                ->onDelete('set null');

            $table->foreignId('chefe_directo')
                ->nullable()
                ->constrained('gestores')
                ->onDelete('set null'); // Auto-relação

            // Dados profissionais
            $table->string('nome', 100);
            $table->string('sobrenome', 100);
            $table->string('telefone', 20)->unique();
            $table->enum('genero', ['Masculino', 'Feminino', 'Outro'])->nullable();
            $table->enum('categoria', ['Senior', 'Técnico Superior de 1ª', 'Técnico Superior de 2ª', 'Técnico Superior de 3ª', 'Especialista', 'N/A'])->nullable();
            $table->date('data_admissao')->nullable();
            $table->string('endereco', 255)->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gestores');
    }
};