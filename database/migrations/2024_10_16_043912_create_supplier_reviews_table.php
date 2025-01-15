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
        Schema::create('supplier_reviews', function (Blueprint $table) {
            $table->id();  // Identificador único de la reseña
            $table->unsignedBigInteger('supplier_id');  // Relación con la tabla suppliers
            $table->integer('calification');  // Calificación del proveedor
            $table->text('review')->nullable();  // Reseña del proveedor (opcional)
            $table->timestamps();

            // Definir la relación con la tabla suppliers
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_reviews');
    }
};
