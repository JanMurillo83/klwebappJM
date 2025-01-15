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
        Schema::create('charges', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('carrier_id')->constrained('carriers')->onDelete('cascade'); // Relación con carriers
            $table->foreignId('charge_type_id')->constrained('charge_types')->onDelete('cascade'); // Relación con charge_types
            $table->text('description')->nullable(); // Descripción del cargo
            $table->decimal('cost', 10, 2); // Costo del cargo
            $table->enum('currency', ['USD', 'MXN']); // Moneda
            $table->decimal('iva', 10, 2)->default(0); // IVA aplicado
            $table->decimal('ret', 10, 2)->default(0); // Retención aplicada
            $table->decimal('discount', 10, 2)->nullable(); // Descuento (si aplica)
            $table->text('discount_description')->nullable(); // Descripción del descuento
            $table->string('claim_number')->nullable(); // Número de reclamo
            $table->enum('claim_status', ['recovered', 'rejected', 'under revision'])->nullable(); // Estado del reclamo
            $table->decimal('recovered_amount', 10, 2)->nullable(); // Monto recuperado
            $table->string('broker_name')->nullable(); // Nombre del broker (si aplica)
            $table->string('bond_number')->nullable(); // Número de bond (si aplica)
            $table->text('additional_info')->nullable(); // Información adicional
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
