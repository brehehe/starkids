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
        Schema::table('user_incentives', function (Blueprint $table) {
            // Add transaction_detail_id for product-based incentives
            if (!Schema::hasColumn('user_incentives', 'transaction_detail_id')) {
                $table->foreignUuid('transaction_detail_id')->nullable()->after('transaction_id')
                    ->comment('ID detail transaksi untuk insentif berbasis produk');
            }
        });

        // Update the status enum to include new product-based incentive statuses
        // PostgreSQL requires dropping and recreating the constraint
        \DB::statement("ALTER TABLE user_incentives DROP CONSTRAINT IF EXISTS user_incentives_status_check");
        \DB::statement("ALTER TABLE user_incentives ADD CONSTRAINT user_incentives_status_check CHECK (status IN ('dokter', 'perawat', 'apoteker', 'kasir', 'perawat_produk', 'dokter_produk'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_incentives', function (Blueprint $table) {
            // Drop transaction_detail_id column
            if (Schema::hasColumn('user_incentives', 'transaction_detail_id')) {
                $table->dropColumn('transaction_detail_id');
            }

            // Revert status enum to original values
            \DB::statement("ALTER TABLE user_incentives DROP CONSTRAINT IF EXISTS user_incentives_status_check");
            \DB::statement("ALTER TABLE user_incentives ADD CONSTRAINT user_incentives_status_check CHECK (status IN ('dokter', 'perawat', 'apoteker', 'kasir'))");
        });
    }
};
