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
            // Permitir que los campos sean nulos
            $table->unsignedBigInteger('shipment_status')->nullable()->change();
            $table->unsignedBigInteger('id_service_detail')->nullable()->change();
            $table->unsignedBigInteger('cargo_id')->nullable()->change();
            $table->unsignedBigInteger('modality_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Revertir los cambios para que los campos no permitan nulos
            $table->unsignedBigInteger('shipment_status')->nullable(false)->change();
            $table->unsignedBigInteger('id_service_detail')->nullable(false)->change();
            $table->unsignedBigInteger('cargo_id')->nullable(false)->change();
            $table->unsignedBigInteger('modality_id')->nullable(false)->change();
        });
    }
};
