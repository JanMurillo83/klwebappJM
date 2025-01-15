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
        Schema::create('service_type_carrier_brokers', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->string('name', 50); // Nombre del tipo de servicio
            $table->string('description', 255); // Descripción del servicio
            $table->timestamps(); // Campos para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_type_carrier_brokers');
    }
};
