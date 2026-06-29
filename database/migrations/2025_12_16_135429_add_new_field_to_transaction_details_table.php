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
        Schema::table('transaction_details', function (Blueprint $table) {
            //
            if (! Schema::hasColumn('transaction_details', 'nurse_id')) {
                $table->foreignUuid('nurse_id')->nullable();
            }
            if (! Schema::hasColumn('transaction_details', 'doctor_id')) {
                $table->foreignUuid('doctor_id')->nullable();
            }
            if (! Schema::hasColumn('transaction_details', 'incentive_nurse')) {
                $table->decimal('incentive_nurse', 15, 2)->default(0);
            }
            if (! Schema::hasColumn('transaction_details', 'incentive_doctor')) {
                $table->decimal('incentive_doctor', 15, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            //
            if (Schema::hasColumn('transaction_details', 'nurse_id')) {
                $table->dropColumn('nurse_id');
            }
            if (Schema::hasColumn('transaction_details', 'doctor_id')) {
                $table->dropColumn('doctor_id');
            }
            if (Schema::hasColumn('transaction_details', 'incentive_nurse')) {
                $table->dropColumn('incentive_nurse');
            }
            if (Schema::hasColumn('transaction_details', 'incentive_doctor')) {
                $table->dropColumn('incentive_doctor');
            }
        });
    }
};
