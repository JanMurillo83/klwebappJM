<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('business_directories', function (Blueprint $table) {
            // Eliminar clave foránea existente
            $table->dropForeign(['factory_company_id']);

            // Hacer que la columna sea nullable
            $table->unsignedBigInteger('factory_company_id')->nullable()->change();

            // Volver a agregar la clave foránea
            $table->foreign('factory_company_id')
                  ->references('id')
                  ->on('factory_companies')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('business_directories', function (Blueprint $table) {
            // Eliminar clave foránea
            $table->dropForeign(['factory_company_id']);

            // Hacer que la columna sea no nullable
            $table->unsignedBigInteger('factory_company_id')->nullable(false)->change();

            // Volver a agregar la clave foránea
            $table->foreign('factory_company_id')
                  ->references('id')
                  ->on('factory_companies')
                  ->onDelete('restrict');
        });
    }
};
