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
        Schema::create('services', function (Blueprint $table) {
            // Definir la clave primaria
            $table->id();

            // Relaciones con otras tablas (foráneas)
            $table->unsignedBigInteger('exchange_rate_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('business_directory_id');
            $table->unsignedBigInteger('shipment_status');
            $table->unsignedBigInteger('id_service_detail');
            $table->unsignedBigInteger('urgency_ltl_id')->nullable();  // nullable si no siempre se usa
            $table->unsignedBigInteger('modality_id');
            $table->unsignedBigInteger('cargo_id');

            // Campos específicos de la tabla
            $table->decimal('rate_to_customer', 10, 2);  // Precio del cliente con precisión
            $table->enum('currency', ['USD', 'MXN']);  // Moneda
            $table->string('billing_customer_reference', 7);  // Referencia de facturación (7 caracteres)
            $table->string('pickup_number')->nullable();  // Número de recogida opcional
            $table->boolean('expedited')->default(false);  // Servicio expedito
            $table->boolean('hazmat')->default(false);  // Transporte de materiales peligrosos
            $table->boolean('team_driver')->default(false);  // Transporte con conductor adicional
            $table->boolean('round_trip')->default(false);  // Viaje de ida y vuelta
            $table->string('un_number', 20)->nullable();  // Número UN opcional para materiales peligrosos
            $table->text('manual_status')->nullable();  // Estado manual (texto largo)
            $table->timestamp('time_status')->nullable();  // Estado de tiempo con timestamp
            $table->date('eta_delivery_status')->nullable();  // ETA de entrega
            $table->string('notes_status')->nullable();  // Notas de estado
            $table->string('sub_services', 255)->nullable();  // Subservicios adicionales

            // Timestamps automáticos
            $table->timestamps();

            // Definir las llaves foráneas
            $table->foreign('exchange_rate_id')->references('id')->on('exchange_rates')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('business_directory_id')->references('id')->on('business_directories')->onDelete('cascade');
            $table->foreign('shipment_status')->references('id')->on('shipment_status')->onDelete('cascade');
            $table->foreign('id_service_detail')->references('id')->on('service_details')->onDelete('cascade');
            $table->foreign('urgency_ltl_id')->references('id')->on('urgency_ltl')->onDelete('cascade');
            $table->foreign('modality_id')->references('id')->on('modality')->onDelete('cascade');
            $table->foreign('cargo_id')->references('id')->on('cargo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
