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
        Schema::create('to_pay', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('carrier_id')->constrained('carriers')->onDelete('cascade'); // Relación con carriers
            $table->decimal('supplier_invoice_amount', 10, 2); // Monto de la factura del proveedor
            $table->string('supplier_invoice_number'); // Número de factura del proveedor
            $table->date('invoice_date'); // Fecha de la factura
            $table->enum('invoice_status', ['accepted', 'returned', 'rejected']); // Estado de la factura
            $table->string('invoice_status_notes')->nullable(); // Notas sobre el estado de la factura
            $table->enum('invoice_payment_status', ['Pending', 'Paid', 'NA']); // Estado del pago
            $table->date('invoice_due_date'); // Fecha de vencimiento de la factura
            $table->date('invoice_payment_date')->nullable(); // Fecha de pago
            $table->enum('payment_term', ['PPD', 'PUE']); // Términos de pago
            $table->enum('payment_complement_received', ['yes', 'no']); // Complemento de pago recibido
            $table->string('attachments')->nullable(); // Archivos adjuntos
            $table->decimal('advancement', 10, 2)->nullable(); // Adelanto
            $table->string('remanent')->nullable(); // Remanente
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_pay');
    }
};
