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
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->dropColumn(['currency_from', 'currency_to']); // Elimina columnas innecesarias
            $table->decimal('exchange_rate', 10, 2)->change();   // Cambia la precisión del tipo de cambio
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exchange_rates', function (Blueprint $table) {
            $table->enum('currency_from', ['USD', 'MXN'])->after('id'); // Recupera las columnas si haces rollback
            $table->enum('currency_to', ['USD', 'MXN'])->after('currency_from');
            $table->decimal('exchange_rate', 10, 6)->change(); // Recupera la precisión original
        });
    }
};
