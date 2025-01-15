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
        Schema::table('services', function (Blueprint $table) {
            // Eliminar la clave foránea existente
            $table->dropForeign(['urgency_ltl_id']);

            // Crear la nueva clave foránea con eliminación en cascada
            $table->foreign('urgency_ltl_id')
                  ->references('id')
                  ->on('urgency_ltl')
                  ->onDelete('cascade'); // Agregar eliminación en cascada
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Eliminar la clave foránea con cascada
            $table->dropForeign(['urgency_ltl_id']);

            // Restaurar la clave foránea sin eliminación en cascada
            $table->foreign('urgency_ltl_id')
                  ->references('id')
                  ->on('urgency_ltl')
                  ->onDelete('set null'); // O cambiar al comportamiento original
        });
    }
};
