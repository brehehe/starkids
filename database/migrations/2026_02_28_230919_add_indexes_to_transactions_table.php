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
            $table->index('company_id');
            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'type']);
            $table->index('patient_company_role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['company_id']);
            $table->dropIndex(['company_id', 'status']);
            $table->dropIndex(['company_id', 'type']);
            $table->dropIndex(['patient_company_role_id']);
        });
    }
};
