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
        Schema::table('products', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('products', 'type_incentive_nurse')) {
                $table->enum('type_incentive_nurse',['percentage','rupiah'])->default('percentage');
            }
            if (!Schema::hasColumn('products', 'incentive_nurse')) {
                $table->decimal('incentive_nurse', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('products', 'type_incentive_doctor')) {
                $table->enum('type_incentive_doctor',['percentage','rupiah'])->default('percentage');
            }
            if (!Schema::hasColumn('products', 'incentive_doctor')) {
                $table->decimal('incentive_doctor', 15, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'type_incentive_nurse',
                'incentive_nurse',
                'type_incentive_doctor',
                'incentive_doctor'
            ]);
        });
    }
};
