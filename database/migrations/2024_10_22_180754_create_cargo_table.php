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
        Schema::create('cargo', function (Blueprint $table) {
            $table->bigIncrements('id'); // Identificador autoincremental
            $table->unsignedBigInteger('handling_type'); // Relación con handling_types
            $table->unsignedBigInteger('material_type'); // Relación con material_types
            $table->unsignedBigInteger('class'); // Relación con freight_classes
            $table->integer('count'); // Número de artículos
            $table->boolean('stackable'); // Apilable (sí/no)
            $table->decimal('weight', 10, 2); // Peso del cargo
            $table->unsignedBigInteger('uom_weight'); // Relación con la tabla uoms para la unidad de medida del peso
            $table->decimal('length', 10, 2); // Longitud
            $table->decimal('width', 10, 2); // Anchura
            $table->decimal('height', 10, 2); // Altura
            $table->unsignedBigInteger('uom_dimensions'); // Relación con la tabla uoms para la unidad de medida de las dimensiones
            $table->decimal('total_yards', 10, 2)->nullable(); // Yardas totales (opcional)
            $table->timestamps(); // Timestamps para created_at y updated_at

            // Definir las claves foráneas
            $table->foreign('handling_type')->references('id')->on('handling_types')->onDelete('cascade');
            $table->foreign('material_type')->references('id')->on('material_types')->onDelete('cascade');
            $table->foreign('class')->references('id')->on('freight_classes')->onDelete('cascade');
            $table->foreign('uom_weight')->references('id')->on('uoms')->onDelete('cascade');
            $table->foreign('uom_dimensions')->references('id')->on('uoms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo');
    }
};
