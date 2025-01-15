<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveServicesColumnsFromSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn([
                'container_drayage',
                'hand_carrier',
                'trailer_rental',
                'charter',
                'air_freight',
                'warehouse',
                'us_custom_broker',
                'transfer',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->boolean('container_drayage')->default(false);
            $table->boolean('hand_carrier')->default(false);
            $table->boolean('trailer_rental')->default(false);
            $table->boolean('charter')->default(false);
            $table->boolean('air_freight')->default(false);
            $table->boolean('warehouse')->default(false);
            $table->boolean('us_custom_broker')->default(false);
            $table->boolean('transfer')->default(false);
        });
    }
}
