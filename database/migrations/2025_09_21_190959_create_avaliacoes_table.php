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
    Schema::create('avaliacoes', function (Blueprint $table) 
       {
    $table->id();
    $table->foreignId('avaliador_id')->constrained('funcionarios')->onDelete('cascade'); // chefe
    $table->foreignId('avaliado_id')->constrained('funcionarios')->onDelete('cascade');  // funcionário
    $table->date('data_avaliacao')->nullable();
    $table->string('observacoes')->nullable();
    $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
