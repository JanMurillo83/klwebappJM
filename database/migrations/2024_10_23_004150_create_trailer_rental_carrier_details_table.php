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
        Schema::create('trailer_rental_carrier_details', function (Blueprint $table) {
            $table->id();  // Llave primaria
            $table->decimal('monthly_rate', 10, 2);  // Tarifa mensual
            $table->string('currency_monthly', 3);  // Moneda de la tarifa mensual (ej. USD, MXN)
            $table->decimal('iva_monthly', 10, 2)->nullable();  // IVA mensual
            $table->decimal('ret_monthly', 10, 2)->nullable();  // Retención mensual
            $table->decimal('alocation_rate', 10, 2);  // Tarifa de asignación
            $table->string('currency_alocation', 3);  // Moneda de la tarifa de asignación
            $table->decimal('iva_alocation', 10, 2)->nullable();  // IVA de asignación
            $table->decimal('ret_alocation', 10, 2)->nullable();  // Retención de asignación
            $table->timestamps();  // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trailer_rental_carrier_details');
    }
};
