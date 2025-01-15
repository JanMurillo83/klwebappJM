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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('directory_entry_id');
            $table->string('name');
            $table->string('last_name');
            $table->string('office_phone')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('email');
            $table->string('working_hours')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        
            $table->foreign('directory_entry_id')->references('id')->on('business_directories')->onDelete('cascade');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
