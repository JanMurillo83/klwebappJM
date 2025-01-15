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
        Schema::create('business_directories', function (Blueprint $table) {
            $table->id(); // Identificador único de la entrada del directorio
            $table->enum('type', ['station', 'customer', 'supplier']);  // Tipo station, customer, supplier
            $table->string('company', 255); // Nombre de la empresa
            $table->string('nickname', 255); // Apodo o nombre corto
            $table->enum('billing_currency', ['USD', 'MXN']); // Moneda de facturación
            $table->string('rfc_tax_id', 20); // RFC o ID de impuestos
            $table->string('street_address', 255); // Dirección de la calle
            $table->string('building_number', 20);  // Número del edificio
            $table->string('neighborhood', 255); // Colonia o barrio
            $table->string('city', 255);  // Ciudad
            $table->string('state', 255); // Estado
            $table->string('postal_code', 10); // Código postal
            $table->string('country', 255); // País
            $table->string('phone', 20); // Teléfono
            $table->string('website', 255)->nullable(); // Sitio web
            $table->string('email', 255); // Correo electrónico
            $table->integer('credit_days')->nullable(); // Días de crédito
            $table->date('credit_expiration_date')->nullable(); // Fecha de expiración del crédito
            $table->integer('free_loading_unloading_hours')->nullable(); // Horas de carga y descarga gratuita
            
            // Agregar la columna para la relación foránea
            $table->unsignedBigInteger('factory_company_id')->nullable(); // Aquí es donde declaras la columna
        
            // Declarar la relación foránea
            $table->foreign('factory_company_id')->references('id')->on('factory_companies')->onDelete('set null');
        
            $table->text('notes')->nullable(); // Notas adicionales
            $table->text('add_document')->nullable(); // Campo para agregar URL de documentos
            $table->date('document_expiration_date')->nullable(); // Fecha de expiración del documento
            $table->string('picture', 255)->nullable(); // URL de la imagen o foto
            $table->text('tarifario')->nullable(); // Tarifario
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_directories');
    }
};