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
        Schema::table('transactions', function (Blueprint $table) {
            //
            if (! Schema::hasColumn('transactions', 'insurance_id')) {
                $table->foreignUuid('insurance_id')->nullable();
            }
            if (! Schema::hasColumn('transactions', 'is_insurance')) {
                $table->boolean('is_insurance')->default(false);
            }
            if (! Schema::hasColumn('transactions', 'is_insurance_claim')) {
                $table->boolean('is_insurance_claim')->default(false);
            }
            if (! Schema::hasColumn('transactions', 'insurance_number')) {
                $table->string('insurance_number')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            if (Schema::hasColumn('transactions', 'insurance_id')) {
                $table->dropColumn('insurance_id');
            }
            if (Schema::hasColumn('transactions', 'is_insurance')) {
                $table->dropColumn('is_insurance');
            }
            if (Schema::hasColumn('transactions', 'is_insurance_claim')) {
                $table->dropColumn('is_insurance_claim');
            }
            if (Schema::hasColumn('transactions', 'insurance_number')) {
                $table->dropColumn('insurance_number');
            }
        });
    }
};
