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
        Schema::table('promotions_simplified', function (Blueprint $table) {
            // Tambahkan kolom JSON untuk targeting yang belum ada
            if (! Schema::hasColumn('promotions_simplified', 'applicable_companies')) {
                $table->json('applicable_companies')->nullable()->after('is_active');
            }
            if (! Schema::hasColumn('promotions_simplified', 'applicable_products')) {
                $table->json('applicable_products')->nullable()->after('applicable_companies');
            }
            if (! Schema::hasColumn('promotions_simplified', 'applicable_user_types')) {
                $table->json('applicable_user_types')->nullable()->after('applicable_products');
            }
            if (! Schema::hasColumn('promotions_simplified', 'applicable_users')) {
                $table->json('applicable_users')->nullable()->after('applicable_user_types');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions_simplified', function (Blueprint $table) {
            $columns = [
                'applicable_companies',
                'applicable_products',
                'applicable_user_types',
                'applicable_users',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('promotions_simplified', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
