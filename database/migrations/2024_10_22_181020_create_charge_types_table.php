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
        Schema::create('charge_types', function (Blueprint $table) {
            $table->bigIncrements('id'); // Identificador único autoincremental
            $table->string('name', 50); // Nombre del tipo de cargo
            $table->string('description', 100)->nullable(); // Descripción del tipo de cargo (opcional)
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charge_types');
    }
};
