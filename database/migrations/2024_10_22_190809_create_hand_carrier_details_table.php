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
        Schema::create('hand_carrier_details', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->string('passenger_name'); // Nombre del pasajero
            $table->string('passport_number'); // Número de pasaporte
            $table->string('passenger_id_number'); // Número de identificación del pasajero
            $table->string('flight_number'); // Número de vuelo
            $table->date('departure_date'); // Fecha de salida
            $table->time('departure_time'); // Hora de salida
            $table->date('arrival_date'); // Fecha de llegada
            $table->time('arrival_time'); // Hora de llegada
            $table->timestamps(); // Campos para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hand_carrier_details');
    }
};
