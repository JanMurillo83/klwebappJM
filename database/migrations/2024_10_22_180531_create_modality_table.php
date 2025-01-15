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
        Schema::create('modality', function (Blueprint $table) {
            $table->bigIncrements('id'); // Identificador autoincremental
            $table->enum('type', ['SINGLE', 'FULL']); // Tipo de modalidad (SINGLE, FULL)
            $table->string('container', 50); // Información del contenedor
            $table->integer('size'); // Tamaño del contenedor
            $table->integer('weight'); // Peso del contenedor
            $table->unsignedBigInteger('uom'); // Relación con la tabla uoms
            $table->unsignedBigInteger('material_type'); // Relación con la tabla material_types
            $table->timestamps(); // Timestamps para created_at y updated_at

            // Definir las relaciones
            $table->foreign('uom')->references('id')->on('uoms')->onDelete('cascade');
            $table->foreign('material_type')->references('id')->on('material_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modality');
    }
};
