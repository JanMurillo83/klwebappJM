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
        Schema::create('urgency_types', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->string('name', 20); // Nombre como 'Economy', 'Guaranteed Delivery'
            $table->string('description', 20)->nullable(); // Descripción opcional
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urgency_types');
    }
};
