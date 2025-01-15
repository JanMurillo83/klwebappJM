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
        Schema::create('carriers', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Relación con services
            $table->foreignId('carrier_detail_id')->constrained('carrier_details')->onDelete('cascade'); // Relación con carrier_details
            $table->foreignId('business_directory_id')->constrained('business_directories')->onDelete('cascade'); // Relación con business_directories
            $table->date('service_date')->nullable(); // Fecha del servicio
            $table->string('tracking_number')->nullable(); // Número de seguimiento
            $table->foreignId('cost_details_id')->constrained('cost_details')->onDelete('cascade'); // Relación con cost_details
            $table->foreignId('equipment_details_id')->nullable()->constrained('equipment_details')->onDelete('set null'); // Relación con equipment_details
            $table->string('gps_link')->nullable(); // Enlace GPS
            $table->integer('port_of_entry')->nullable(); // Puerto de entrada
            $table->foreignId('pickup_details_id')->nullable()->constrained('pickup_details')->onDelete('set null'); // Relación con pickup_details
            $table->foreignId('delivery_details_id')->nullable()->constrained('delivery_details')->onDelete('set null'); // Relación con delivery_details
            $table->foreignId('service_type_carrier_broker_id')->nullable()->constrained('service_type_carrier_brokers')->onDelete('set null'); // Relación con service_type_carrier_brokers
            $table->string('arrival_requested')->nullable(); // Llegada solicitada
            $table->string('cancelation_requested')->nullable(); // Cancelación solicitada
            $table->foreignId('hand_carrier_detail_id')->nullable()->constrained('hand_carrier_details')->onDelete('set null'); // Relación con hand_carrier_details
            $table->foreignId('trailer_rental_carrier_detail_id')->nullable()->constrained('trailer_rental_carrier_details')->onDelete('set null'); // Relación con trailer_rental_carrier_details
            $table->foreignId('charter_carrier_detail_id')->nullable()->constrained('charter_carrier_details')->onDelete('set null'); // Relación con charter_carrier_details
            $table->enum('transfer_type', ['Export', 'Import'])->nullable(); // Tipo de transferencia
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carriers');
    }
};
