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
        Schema::table('consignees', function (Blueprint $table) {
            $table->date('delivery_date_requested')->nullable()->change();
            $table->time('delivery_time_requested')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consignees', function (Blueprint $table) {
            $table->date('delivery_date_requested')->nullable(false)->change();
            $table->time('delivery_time_requested')->nullable(false)->change();
        });
    }
};
