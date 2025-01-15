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
        schema::create('urgency_ltl', function (Blueprint $table) {
            $table->bigIncrements('id'); // Identificador autoincremental
            $table->unsignedBigInteger('type'); // Relación con la tabla urgency_types
            $table->string('emergency_company', 50); // Nombre de la compañía de emergencia
            $table->string('company_ID', 50); // ID de la compañía
            $table->string('phone', 15); // Teléfono de contacto
            $table->timestamps(); // Timestamps para created_at y updated_at

            // Definir la relación con urgency_types
            $table->foreign('type')->references('id')->on('urgency_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urgency_ltl');
    }
};
