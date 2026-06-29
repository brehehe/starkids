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
            if (! Schema::hasColumn('promotion_simplified', 'buy_x_get_y_rules')) {
                $table->json('buy_x_get_y_rules')->nullable()->after('discount_products');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotion_simplified', function (Blueprint $table) {
            if (Schema::hasColumn('promotion_simplified', 'buy_x_get_y_rules')) {
                $table->dropColumn('buy_x_get_y_rules');
            }
        });
    }
};
