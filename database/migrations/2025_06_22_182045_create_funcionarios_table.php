<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->unsignedBigInteger('cargo_id')->nullable();
            $table->unsignedBigInteger('dept_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('data_admissao')->nullable();
            $table->unsignedBigInteger('chefe_id')->nullable();
            $table->string('categoria')->nullable();;
            $table->string('estado')->default('activo');
            $table->timestamps();

            $table->foreign('cargo_id')->references('id')->on('cargos')->nullOnDelete();
            $table->foreign('dept_id')->references('id')->on('departamento')->nullOnDelete();
            $table->foreign('chefe_id')->references('id')->on('funcionarios')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

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
