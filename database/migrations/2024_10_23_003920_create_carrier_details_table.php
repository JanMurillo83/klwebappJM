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
        Schema::create('carrier_details', function (Blueprint $table) {
            $table->id();  // Llave primaria
            $table->string('name', 50);  // Tipo de carrera que se hace en el servicio: 'us carrier, us customs broker, etc.'
            $table->string('description')->nullable();  // Descripción opcional
            $table->unsignedBigInteger('id_service_detail');  // Relación con service_details
            $table->timestamps();  // Campos created_at y updated_at

            // Llave foránea para id_service_detail
            $table->foreign('id_service_detail')->references('id')->on('service_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_details');
    }
};
