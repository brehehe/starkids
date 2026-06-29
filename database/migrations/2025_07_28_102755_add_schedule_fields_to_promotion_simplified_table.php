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
        Schema::table('promotion_simplified', function (Blueprint $table) {
            // Schedule configuration fields
            // $table->string('schedule_type')->default('always')->after('applicable_days');
            // $table->jsonb('specific_days')->nullable()->after('schedule_type');
            // $table->time('specific_start_time')->nullable()->after('specific_days');
            // $table->time('specific_end_time')->nullable()->after('specific_start_time');
            // $table->boolean('apply_time_to_days')->default(false)->after('specific_end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotion_simplified', function (Blueprint $table) {
            $table->dropColumn([
                'schedule_type',
                'specific_days',
                'specific_start_time',
                'specific_end_time',
                'apply_time_to_days',
            ]);
        });
    }
};
