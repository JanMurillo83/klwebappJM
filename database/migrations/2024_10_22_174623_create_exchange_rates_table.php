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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->enum('currency_from', ['USD', 'MXN']); // Moneda de origen
            $table->enum('currency_to', ['USD', 'MXN']); // Moneda de destino
            $table->decimal('exchange_rate', 10, 6); // Tipo de cambio con precisión decimal
            $table->date('effective_date'); // Fecha en que es efectivo el tipo de cambio
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
