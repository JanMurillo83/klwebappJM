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
        Schema::create('uoms', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->string('name', 20); // Nombre como 'kg', 'lbs', 'in', 'ft'
            $table->string('description')->nullable();//'Unidades de Peso', 'Unidades de Longitud', 'Unidades de Volumen' Descripción con valores predefinidos
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uoms');
    }
};
