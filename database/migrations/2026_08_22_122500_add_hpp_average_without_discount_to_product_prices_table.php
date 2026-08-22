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
        if (Schema::hasTable('product_prices') && !Schema::hasColumn('product_prices', 'hpp_average_without_discount')) {
            Schema::table('product_prices', function (Blueprint $table) {
                $table->decimal('hpp_average_without_discount', 15, 2)->default(0)->after('hpp_average');
            });
        }

        if (Schema::hasTable('product_selling_price_histories') && !Schema::hasColumn('product_selling_price_histories', 'margin')) {
            Schema::table('product_selling_price_histories', function (Blueprint $table) {
                $table->decimal('margin', 8, 2)->default(0)->after('new_hpp_average');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('product_prices') && Schema::hasColumn('product_prices', 'hpp_average_without_discount')) {
            Schema::table('product_prices', function (Blueprint $table) {
                $table->dropColumn('hpp_average_without_discount');
            });
        }

        if (Schema::hasTable('product_selling_price_histories') && Schema::hasColumn('product_selling_price_histories', 'margin')) {
            Schema::table('product_selling_price_histories', function (Blueprint $table) {
                $table->dropColumn('margin');
            });
        }
    }
};
