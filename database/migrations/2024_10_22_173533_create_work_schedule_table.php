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
        Schema::create('work_schedule', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID autoincremental
            $table->unsignedBigInteger('employee_id'); // Relación con la tabla employees
            $table->string('day_of_week'); // Día de la semana (ej. monday, tuesday)
            $table->time('time_in'); // Hora de entrada
            $table->time('time_out'); // Hora de salida
            $table->timestamps(); // created_at y updated_at

            // Definir la relación con la tabla employees
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade'); // Elimina el horario si se elimina el empleado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedule');
    }
};
