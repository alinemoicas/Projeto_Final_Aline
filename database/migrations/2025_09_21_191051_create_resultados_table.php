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
        Schema::create('resultados', function (Blueprint $table) 
        {
            $table->id();
            $table->foreignId('avaliacao_id')->constrained('avaliacoes')->onDelete('cascade');
            $table->decimal('pontuacao_final', 6, 2);
            $table->string('classificacao')->nullable(); // Excelente, Bom, Regular, etc.
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
