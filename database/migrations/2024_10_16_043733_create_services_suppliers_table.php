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
        Schema::create('services_suppliers', function (Blueprint $table) {
            $table->id();  // Identificador único del registro
            $table->unsignedBigInteger('supplier_id');  // Relación con la tabla de proveedores (suppliers)
            $table->unsignedBigInteger('id_service_detail');  // Relación con la tabla de detalles de servicios (service_details)
            $table->timestamps();

            // Relaciones con claves foráneas
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('id_service_detail')->references('id')->on('service_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_suppliers');
    }
};
