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
        Schema::create('cost_details', function (Blueprint $table) {
            $table->id();  // Primary Key
            $table->decimal('freight_rate', 10, 2);  // Freight rate cost
            $table->enum('currency', ['USD', 'MXN']);  // Currency type
            $table->decimal('iva', 10, 2);  // VAT (Impuesto al Valor Agregado)
            $table->decimal('ret', 10, 2);  // Retention value (e.g. tax withholding)
            $table->string('gps_link', 255)->nullable();  // Optional GPS link
            $table->timestamps();  // created_at and updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_details');
    }
};
