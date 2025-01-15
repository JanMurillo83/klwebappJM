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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();  // Identificador único del proveedor
            $table->unsignedBigInteger('directory_entry_id');  // Relación con la tabla de entradas del directorio
            $table->string('mc_number', 20)->nullable();  // Número MC
            $table->string('usdot', 20)->nullable();  // Número USDOT
            $table->string('scac', 20)->nullable();  // Código SCAC
            $table->string('caat', 20)->nullable();  // Código CAAT
            $table->boolean('container_drayage')->default(false);  // Servicio de transporte de contenedores
            $table->boolean('hand_carrier')->default(false);  // Servicio de mensajería
            $table->boolean('trailer_rental')->default(false);  // Alquiler de remolques
            $table->boolean('charter')->default(false);  // Servicio de fletamento
            $table->boolean('air_freight')->default(false);  // Servicio de transporte aéreo
            $table->boolean('warehouse')->default(false);  // Servicio de almacenamiento
            $table->boolean('us_custom_broker')->default(false);  // Servicio de corredor de aduanas en EE.UU.
            $table->boolean('transfer')->default(false);  // Servicio de transferencia
            $table->timestamps();

            // Relación con business_directories
            $table->foreign('directory_entry_id')->references('id')->on('business_directories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
