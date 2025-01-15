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
        Schema::create('stop_offs', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade'); // Relación con services
            $table->enum('role', ['shipper', 'consignee']); // Rol de la parada
            $table->foreignId('business_directory_id')->constrained('business_directories')->onDelete('cascade'); // Relación con business_directories
            $table->integer('position'); // Posición para manejar el orden
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stop_offs');
    }
};
