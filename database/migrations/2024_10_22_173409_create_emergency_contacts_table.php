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
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->unsignedBigInteger('employee_id'); // Llave foránea relacionada con employees
            $table->string('name'); // Nombre del contacto de emergencia
            $table->string('relationship'); // Relación con el empleado (ej. hermano, cónyuge, etc.)
            $table->string('phone'); // Teléfono del contacto
            $table->timestamps(); // created_at y updated_at

            // Relación con la tabla employees
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade'); // Borra contactos si se elimina el empleado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};
