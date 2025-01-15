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
        Schema::create('supplier_equipments', function (Blueprint $table) {
            $table->id();  // Identificador único del equipo
            $table->unsignedBigInteger('supplier_id');  // Relación con la tabla de proveedores (suppliers)
            $table->string('equipment', 255);  // Nombre o tipo del equipo
            $table->text('description')->nullable();  // Descripción del equipo (opcional)
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
        Schema::dropIfExists('supplier_equipments');
    }
};
