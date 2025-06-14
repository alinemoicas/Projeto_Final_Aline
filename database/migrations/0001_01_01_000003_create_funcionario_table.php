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
        Schema::create('funcionario', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->integer('telefone')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('cargo')->nullable();
            $table->string('categoria')->nullable();
            $table->foreignId('dept_id')->constrained()->onDelete('cascade');
            $table->string('estado');
            $table->timestamps();
        });
      
    }
};