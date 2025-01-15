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
        Schema::create('pickup_details', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->date('real_pickup_date'); // Fecha de recogida real
            $table->time('in_time'); // Hora de entrada
            $table->time('out_time'); // Hora de salida
            $table->decimal('detention_hours', 5, 2); // Horas de detención con dos decimales
            $table->timestamps(); // Timestamps automáticos para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_details');
    }
};
