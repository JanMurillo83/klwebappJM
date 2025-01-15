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
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->string('street_address'); // Dirección de la calle
            $table->integer('building_number'); // Número del edificio
            $table->string('neighborhood')->nullable(); // Colonia o barrio (puede ser opcional)
            $table->string('city'); // Ciudad
            $table->string('state'); // Estado
            $table->string('postal_code'); // Código postal
            $table->string('country'); // País
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
