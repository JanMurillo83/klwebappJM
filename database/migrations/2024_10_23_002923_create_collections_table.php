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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();  // Llave primaria
            $table->unsignedBigInteger('service_id');  // Relación con la tabla services
            $table->decimal('total_shipping_cost', 10, 2);  // Costo total del envío
            $table->decimal('exchange_rate', 10, 4);  // Tipo de cambio
            $table->decimal('freight_charges', 10, 2);  // Cargos por flete
            $table->decimal('accessory_charges', 10, 2);  // Cargos accesorios
            $table->decimal('total_kronos_invoice', 10, 2);  // Total de la factura Kronos
            $table->decimal('gross_profit', 10, 2);  // Ganancia bruta
            $table->decimal('commission', 10, 2);  // Comisión
            $table->decimal('net_profit', 10, 2);  // Ganancia neta
            $table->string('kronos_invoice_number');  // Número de factura Kronos
            $table->string('sat_kronos_invoice_number');  // Número de factura SAT de Kronos
            $table->enum('invoice_sent', ['yes', 'no']);  // Si la factura fue enviada
            $table->date('invoice_sent_date')->nullable();  // Fecha de envío de la factura
            $table->date('kronos_invoice_due_date');  // Fecha de vencimiento de la factura Kronos
            $table->decimal('number_of_days_overdue', 5, 2)->nullable();  // Días de retraso en el pago
            $table->enum('payment_status', ['paid', 'pending', 'na']);  // Estado del pago
            $table->date('payment_date')->nullable();  // Fecha de pago
            $table->boolean('payment_addendum_attached')->nullable();  // Si se adjuntó el anexo de pago
            $table->enum('payment_sent', ['yes', 'no']);  // Si el pago fue enviado
            $table->timestamps();  // Campos created_at y updated_at
            
            // Definir la relación con la tabla services
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
