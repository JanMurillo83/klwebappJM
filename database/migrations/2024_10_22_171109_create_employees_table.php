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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->unsignedBigInteger('user_id')->nullable(); // Relación con la tabla de usuarios, opcional
            $table->string('name', 255); // Nombre del empleado
            $table->string('last_name', 255); // Apellido del empleado
            $table->string('email', 255)->unique(); // Correo electrónico único
            $table->string('phone', 20); // Teléfono
            $table->string('job_title', 255); // Título del puesto
            $table->string('office', 255); // Oficina
            $table->date('birthday'); // Fecha de nacimiento
            $table->date('date_of_hire'); // Fecha de contratación
            $table->unsignedBigInteger('address_id'); // Relación con la tabla de direcciones
            $table->string('NSS')->nullable(); // Número de Seguridad Social
            $table->string('tax_status_certificate')->nullable(); // Certificado de estado fiscal
            $table->string('id_ine')->nullable(); // INE
            $table->string('social_security_number')->nullable(); // Número de seguro social
            $table->string('proof_of_address')->nullable(); // Comprobante de domicilio
            $table->timestamps(); // created_at y updated_at

            // Llaves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); // Relación con usuarios
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade'); // Relación con direcciones
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
