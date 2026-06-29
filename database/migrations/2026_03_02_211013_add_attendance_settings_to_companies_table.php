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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('work_days')->nullable()->after('description');
            $table->time('clock_in_time')->nullable()->after('work_days');
            $table->time('clock_out_time')->nullable()->after('clock_in_time');
            $table->decimal('latitude', 10, 8)->nullable()->after('clock_out_time');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->integer('attendance_radius')->nullable()->after('longitude')->comment('in meters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'work_days',
                'clock_in_time',
                'clock_out_time',
                'latitude',
                'longitude',
                'attendance_radius',
            ]);
        });
    }
};
