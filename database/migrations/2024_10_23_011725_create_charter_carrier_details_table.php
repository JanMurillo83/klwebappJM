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
        Schema::create('charter_carrier_details', function (Blueprint $table) {
            $table->id(); // Llave primaria
            $table->date('pickup_date'); // Fecha de recogida
            $table->date('delivery_date_requested'); // Fecha de entrega solicitada
            $table->time('time'); // Hora
            $table->time('actual_delivery_time'); // Hora de entrega real
            $table->integer('flight_number'); // Número de vuelo
            $table->integer('tail_number'); // Número de cola
            $table->date('departure_date'); // Fecha de salida
            $table->time('departure_time'); // Hora de salida
            $table->date('arrival_date'); // Fecha de llegada
            $table->time('arrival_time'); // Hora de llegada
            $table->decimal('cost_per_hour', 10, 2); // Costo por hora
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charter_carrier_details');
    }
};
