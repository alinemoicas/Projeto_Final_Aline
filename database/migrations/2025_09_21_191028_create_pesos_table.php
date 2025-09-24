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
    Schema::create('pesos', function (Blueprint $table) {
    $table->id();
    $table->foreignId('criterio_id')->constrained('criterios')->onDelete('cascade');
    $table->decimal('valor', 5, 2); // em percentagem
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesos');
    }
};
