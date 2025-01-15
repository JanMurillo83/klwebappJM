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
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->unsignedBigInteger('employee_id'); // Relación con la tabla employees
            $table->string('type'); // Tipo de dispositivo (computer o cellphone)
            $table->string('brand'); // Marca del dispositivo
            $table->string('model'); // Modelo del dispositivo
            $table->string('serial_number'); // Número de serie
            $table->string('color')->nullable(); // Color del dispositivo
            $table->boolean('charger_cable_recived')->default(false); // Indicador de si el cargador/cable fue recibido
            $table->timestamps(); // created_at y updated_at

            // Llave foránea
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade'); // Relación con employees
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
