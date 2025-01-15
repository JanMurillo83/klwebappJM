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
        Schema::create('bank_details', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->unsignedBigInteger('employee_id'); // Relación con la tabla employees
            $table->string('bank_name', 255); // Nombre del banco
            $table->string('account_number', 255); // Número de cuenta
            $table->string('card_number', 255); // Número de tarjeta
            $table->string('clabe', 18); // CLABE bancaria
            $table->timestamps(); // created_at y updated_at

            // Llave foránea
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade'); // Relación con employees
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_details');
    }
};
