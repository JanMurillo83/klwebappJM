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
        Schema::create('delivery_details', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->date('real_delivery_date'); // Fecha de entrega real
            $table->time('delivery_in_time'); // Hora de entrada de entrega
            $table->time('delivery_out_time'); // Hora de salida de entrega
            $table->decimal('delivery_detention_hours', 5, 2); // Horas de detención en la entrega
            $table->timestamps(); // Timestamps automáticos para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_details');
    }
};
