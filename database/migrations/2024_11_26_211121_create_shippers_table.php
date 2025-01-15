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
        Schema::create('shippers', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Relación con la tabla services
            $table->date('requested_pickup_date'); // Fecha solicitada de recolección
            $table->time('time'); // Hora de recolección
            $table->date('scheduled_border_crossing_date'); // Fecha programada de cruce fronterizo
            $table->date('drop_reception_date')->nullable(); // Fecha de recepción (opcional)
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippers');
    }
};
