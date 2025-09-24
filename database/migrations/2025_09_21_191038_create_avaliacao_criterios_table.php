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
        Schema::create('avaliacao_criterios', function (Blueprint $table) {
    $table->id();
    $table->foreignId('avaliacao_id')->constrained('avaliacoes')->onDelete('cascade');
    $table->foreignId('criterio_id')->constrained('criterios')->onDelete('cascade');
    $table->decimal('nota', 5, 2); // nota atribuída
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacao_criterios');
    }
};
