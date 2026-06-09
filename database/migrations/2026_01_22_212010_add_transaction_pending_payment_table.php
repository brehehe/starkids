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
            if (!Schema::hasColumn('transactions', 'is_pending_payment')) {
                $table->boolean('is_pending_payment')->default(false);
            }
            if (!Schema::hasColumn('transactions', 'status_payment')) {
                $table->enum('status_payment',['draft','partial','paid'])->default('paid');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['is_pending_payment', 'status_payment']);
        });
    }
};
