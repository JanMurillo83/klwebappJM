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
        Schema::table('users', function (Blueprint $table) {
            $table->string('last_name', 255)->after('name'); // Add last_name after the name column
            $table->string('phone', 20)->nullable()->after('last_name'); // Add phone, nullable, after role
            $table->string('job_title', 255)->nullable()->after('phone'); // Add job_title, nullable, after phone
            $table->string('office', 255)->nullable()->after('job_title'); // Add office, nullable, after job_title
            $table->date('birthday')->nullable()->after('office'); // Add birthday, nullable, after office
            $table->date('date_of_hire')->nullable()->after('birthday'); // Add date_of_hire, nullable, after birthday
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_name', 'phone', 'job_title', 'office', 'birthday', 'date_of_hire']);
        });
    }
};
