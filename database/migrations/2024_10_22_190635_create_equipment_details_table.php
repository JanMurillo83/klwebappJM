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
        Schema::create('equipment_details', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->string('equipment'); // Para enlazar con los equipos del proveedor
            $table->string('truck_number'); // Número del camión
            $table->string('truck_plates'); // Placas del camión
            $table->string('trailer_number'); // Número del remolque
            $table->string('trailer_plates'); // Placas del remolque
            $table->timestamps(); // Marcas de tiempo automáticas (created_at y updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_details');
    }
};
