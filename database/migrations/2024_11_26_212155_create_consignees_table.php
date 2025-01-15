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
        Schema::create('consignees', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Relación con services
            $table->date('delivery_date_requested'); // Fecha solicitada para entrega
            $table->time('delivery_time_requested'); // Hora solicitada para entrega
            $table->date('actual_delivery_date')->nullable(); // Fecha real de entrega (Container Drayage)
            $table->time('actual_time')->nullable(); // Hora real de entrega (Container Drayage)
            $table->date('withdrawal_date')->nullable(); // Fecha de retiro (trailer rental y warehouse)
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consignees');
    }
};
