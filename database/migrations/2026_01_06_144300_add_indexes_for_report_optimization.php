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
        // Indexes for transaction_icd10s table
        Schema::table('transaction_icd10s', function (Blueprint $table) {
            // Index for date range queries (whereBetween created_at)
            $table->index('created_at', 'idx_transaction_icd10s_created_at');

            // Index for grouping by icd10_id
            $table->index('icd10_id', 'idx_transaction_icd10s_icd10_id');

            // Index for joining with transactions
            $table->index('transaction_id', 'idx_transaction_icd10s_transaction_id');

            // Composite index for common query pattern (date + icd10)
            $table->index(['created_at', 'icd10_id'], 'idx_transaction_icd10s_date_icd10');
        });

        // Indexes for transactions table
        Schema::table('transactions', function (Blueprint $table) {
            // Index for joining with patients (users)
            if (! Schema::hasColumn('transactions', 'patient_id')) {
                // Skip if column doesn't exist
                return;
            }

            $table->index('patient_id', 'idx_transactions_patient_id');

            // Index for date queries if needed
            $table->index('created_at', 'idx_transactions_created_at');
        });

        // Indexes for user_details table
        Schema::table('user_details', function (Blueprint $table) {
            // Index for joining with users
            if (! Schema::hasColumn('user_details', 'user_id')) {
                // Skip if column doesn't exist
                return;
            }

            $table->index('user_id', 'idx_user_details_user_id');

            // Index for birth_date (used in age calculations)
            if (Schema::hasColumn('user_details', 'birth_date')) {
                $table->index('birth_date', 'idx_user_details_birth_date');
            }

            // Index for gender filtering
            if (Schema::hasColumn('user_details', 'administrative_gender')) {
                $table->index('administrative_gender', 'idx_user_details_gender');
            }
        });

        // Indexes for icd10s table
        Schema::table('icd10s', function (Blueprint $table) {
            // Index for code lookups
            $table->index('code', 'idx_icd10s_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop transaction_icd10s indexes
        Schema::table('transaction_icd10s', function (Blueprint $table) {
            $table->dropIndex('idx_transaction_icd10s_created_at');
            $table->dropIndex('idx_transaction_icd10s_icd10_id');
            $table->dropIndex('idx_transaction_icd10s_transaction_id');
            $table->dropIndex('idx_transaction_icd10s_date_icd10');
        });

        // Drop transactions indexes
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasIndex('transactions', 'idx_transactions_patient_id')) {
                $table->dropIndex('idx_transactions_patient_id');
            }
            if (Schema::hasIndex('transactions', 'idx_transactions_created_at')) {
                $table->dropIndex('idx_transactions_created_at');
            }
        });

        // Drop user_details indexes
        Schema::table('user_details', function (Blueprint $table) {
            if (Schema::hasIndex('user_details', 'idx_user_details_user_id')) {
                $table->dropIndex('idx_user_details_user_id');
            }
            if (Schema::hasIndex('user_details', 'idx_user_details_birth_date')) {
                $table->dropIndex('idx_user_details_birth_date');
            }
            if (Schema::hasIndex('user_details', 'idx_user_details_gender')) {
                $table->dropIndex('idx_user_details_gender');
            }
        });

        // Drop icd10s indexes
        Schema::table('icd10s', function (Blueprint $table) {
            $table->dropIndex('idx_icd10s_code');
        });
    }
};
