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
        Schema::table('promotions', function (Blueprint $table) {
            // Enhanced Buy X Get Y Configuration - check if columns exist first
            if (!Schema::hasColumn('promotions', 'buy_products')) {
                $table->jsonb('buy_products')->nullable()->after('get_quantity'); // Produk yang harus dibeli
            }
            if (!Schema::hasColumn('promotions', 'get_products')) {
                $table->jsonb('get_products')->nullable()->after('buy_products'); // Produk yang didapat gratis
            }
            if (!Schema::hasColumn('promotions', 'buy_get_mode')) {
                $table->enum('buy_get_mode', ['same_product', 'different_product', 'category_based'])->nullable()->after('get_products');
            }

            // Bundle Configuration
            if (!Schema::hasColumn('promotions', 'bundle_products')) {
                $table->jsonb('bundle_products')->nullable()->after('buy_get_mode'); // [{product_id, quantity, price}]
            }
            if (!Schema::hasColumn('promotions', 'bundle_price')) {
                $table->decimal('bundle_price', 15, 2)->nullable()->after('bundle_products'); // Harga paket bundle
            }
            if (!Schema::hasColumn('promotions', 'bundle_discount')) {
                $table->decimal('bundle_discount', 15, 2)->nullable()->after('bundle_price'); // Diskon bundle
            }

            // Tier-based Discount (Multiple thresholds)
            if (!Schema::hasColumn('promotions', 'discount_tiers')) {
                $table->jsonb('discount_tiers')->nullable()->after('bundle_discount'); // [{min_amount, discount_value, max_discount}]
            }

            // Product-specific Discount
            if (!Schema::hasColumn('promotions', 'product_discounts')) {
                $table->jsonb('product_discounts')->nullable()->after('discount_tiers'); // [{product_id, discount_value, max_discount}]
            }

            // Cashback Configuration
            if (!Schema::hasColumn('promotions', 'cashback_percentage')) {
                $table->decimal('cashback_percentage', 5, 2)->nullable()->after('product_discounts'); // Persentase cashback
            }
            if (!Schema::hasColumn('promotions', 'max_cashback')) {
                $table->decimal('max_cashback', 15, 2)->nullable()->after('cashback_percentage'); // Maksimal cashback
            }
            if (!Schema::hasColumn('promotions', 'cashback_type')) {
                $table->enum('cashback_type', ['instant', 'delayed', 'points'])->nullable()->after('max_cashback');
            }

            // Shipping Configuration
            if (!Schema::hasColumn('promotions', 'free_shipping_threshold')) {
                $table->decimal('free_shipping_threshold', 15, 2)->nullable()->after('cashback_type'); // Minimal untuk gratis ongkir
            }

            // Loyalty Points Configuration
            if (!Schema::hasColumn('promotions', 'points_multiplier')) {
                $table->decimal('points_multiplier', 5, 2)->nullable()->after('free_shipping_threshold'); // Multiplier poin
            }
            if (!Schema::hasColumn('promotions', 'bonus_points')) {
                $table->integer('bonus_points')->nullable()->after('points_multiplier'); // Bonus poin tetap
            }

            // Usage tracking
            if (!Schema::hasColumn('promotions', 'max_usage')) {
                $table->integer('max_usage')->nullable()->after('bonus_points'); // Maksimal penggunaan total
            }
            if (!Schema::hasColumn('promotions', 'current_usage')) {
                $table->integer('current_usage')->default(0)->after('max_usage'); // Penggunaan saat ini
            }
            if (!Schema::hasColumn('promotions', 'max_usage_per_user')) {
                $table->integer('max_usage_per_user')->nullable()->after('current_usage'); // Maksimal per user
            }

            // First time buyer restriction
            if (!Schema::hasColumn('promotions', 'is_first_purchase_only')) {
                $table->boolean('is_first_purchase_only')->default(false)->after('max_usage_per_user');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $columns = [
                'buy_products',
                'get_products',
                'buy_get_mode',
                'bundle_products',
                'bundle_price',
                'bundle_discount',
                'discount_tiers',
                'product_discounts',
                'cashback_percentage',
                'max_cashback',
                'cashback_type',
                'free_shipping_threshold',
                'points_multiplier',
                'bonus_points',
                'max_usage',
                'current_usage',
                'max_usage_per_user',
                'is_first_purchase_only'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('promotions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
