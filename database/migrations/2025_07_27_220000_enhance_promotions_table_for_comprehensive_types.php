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
            // Enhanced promotion fields - check if columns exist first
            if (! Schema::hasColumn('promotions', 'buy_get_mode')) {
                $table->string('buy_get_mode')->default('same_product')->after('get_quantity');
            }
            if (! Schema::hasColumn('promotions', 'buy_products')) {
                $table->jsonb('buy_products')->nullable()->after('buy_get_mode');
            }
            if (! Schema::hasColumn('promotions', 'get_products')) {
                $table->jsonb('get_products')->nullable()->after('buy_products');
            }
            if (! Schema::hasColumn('promotions', 'bundle_products')) {
                $table->jsonb('bundle_products')->nullable()->after('get_products');
            }
            if (! Schema::hasColumn('promotions', 'bundle_price')) {
                $table->decimal('bundle_price', 15, 2)->nullable()->after('bundle_products');
            }
            if (! Schema::hasColumn('promotions', 'bundle_discount')) {
                $table->decimal('bundle_discount', 15, 2)->nullable()->after('bundle_price');
            }
            if (! Schema::hasColumn('promotions', 'discount_tiers')) {
                $table->jsonb('discount_tiers')->nullable()->after('bundle_discount'); // For tier_discount type
            }
            if (! Schema::hasColumn('promotions', 'product_discounts')) {
                $table->jsonb('product_discounts')->nullable()->after('discount_tiers'); // For product_specific type
            }
            if (! Schema::hasColumn('promotions', 'cashback_percentage')) {
                $table->decimal('cashback_percentage', 5, 2)->nullable()->after('product_discounts');
            }
            if (! Schema::hasColumn('promotions', 'max_cashback')) {
                $table->decimal('max_cashback', 15, 2)->nullable()->after('cashback_percentage');
            }
            if (! Schema::hasColumn('promotions', 'cashback_type')) {
                $table->string('cashback_type')->default('instant')->after('max_cashback'); // instant, wallet, credit
            }
            if (! Schema::hasColumn('promotions', 'free_shipping_threshold')) {
                $table->decimal('free_shipping_threshold', 15, 2)->nullable()->after('cashback_type');
            }
            if (! Schema::hasColumn('promotions', 'points_multiplier')) {
                $table->decimal('points_multiplier', 8, 2)->default(1)->after('free_shipping_threshold');
            }
            if (! Schema::hasColumn('promotions', 'bonus_points')) {
                $table->integer('bonus_points')->default(0)->after('points_multiplier');
            }
            if (! Schema::hasColumn('promotions', 'max_usage')) {
                $table->integer('max_usage')->nullable()->after('bonus_points');
            }
            if (! Schema::hasColumn('promotions', 'current_usage')) {
                $table->integer('current_usage')->default(0)->after('max_usage');
            }
            if (! Schema::hasColumn('promotions', 'max_usage_per_user')) {
                $table->integer('max_usage_per_user')->nullable()->after('current_usage');
            }
            if (! Schema::hasColumn('promotions', 'is_first_purchase_only')) {
                $table->boolean('is_first_purchase_only')->default(false)->after('max_usage_per_user');
            }

            // Product Specific Discount Enhancement
            if (! Schema::hasColumn('promotions', 'product_discount_mode')) {
                $table->string('product_discount_mode')->default('auto')->after('is_first_purchase_only'); // auto, manual, selective
            }
            if (! Schema::hasColumn('promotions', 'discount_application')) {
                $table->string('discount_application')->default('immediate')->after('product_discount_mode'); // immediate, checkout, coupon_required
            }

            // Volume discount settings
            if (! Schema::hasColumn('promotions', 'volume_tiers')) {
                $table->jsonb('volume_tiers')->nullable()->after('discount_application'); // For volume_discount type
            }

            // Membership discount settings
            if (! Schema::hasColumn('promotions', 'membership_levels')) {
                $table->jsonb('membership_levels')->nullable()->after('volume_tiers'); // For membership_discount type
            }

            // Seasonal discount settings
            if (! Schema::hasColumn('promotions', 'seasonal_conditions')) {
                $table->jsonb('seasonal_conditions')->nullable()->after('membership_levels'); // For seasonal_discount type
            }

            // Enhanced usage tracking
            if (! Schema::hasColumn('promotions', 'usage_analytics')) {
                $table->jsonb('usage_analytics')->nullable()->after('seasonal_conditions'); // Track detailed usage data
            }

            // Customer segmentation
            if (! Schema::hasColumn('promotions', 'customer_segments')) {
                $table->jsonb('customer_segments')->nullable()->after('usage_analytics'); // For advanced targeting
            }

            // Geographic restrictions
            if (! Schema::hasColumn('promotions', 'geographic_restrictions')) {
                $table->jsonb('geographic_restrictions')->nullable()->after('customer_segments'); // City, province restrictions
            }

            // Time-based restrictions
            if (! Schema::hasColumn('promotions', 'time_restrictions')) {
                $table->jsonb('time_restrictions')->nullable()->after('geographic_restrictions'); // Hour-based, day-based
            }

            // Combination rules
            if (! Schema::hasColumn('promotions', 'allow_combination')) {
                $table->boolean('allow_combination')->default(false)->after('time_restrictions');
            }
            if (! Schema::hasColumn('promotions', 'combination_rules')) {
                $table->jsonb('combination_rules')->nullable()->after('allow_combination');
            }

            // Advanced settings
            if (! Schema::hasColumn('promotions', 'max_discount_per_item')) {
                $table->integer('max_discount_per_item')->nullable()->after('combination_rules');
            }
            if (! Schema::hasColumn('promotions', 'max_total_discount')) {
                $table->decimal('max_total_discount', 15, 2)->nullable()->after('max_discount_per_item');
            }
            if (! Schema::hasColumn('promotions', 'requires_code')) {
                $table->boolean('requires_code')->default(false)->after('max_total_discount');
            }
            if (! Schema::hasColumn('promotions', 'promo_code_pattern')) {
                $table->string('promo_code_pattern')->nullable()->after('requires_code');
            }

            // A/B Testing support
            if (! Schema::hasColumn('promotions', 'test_group')) {
                $table->string('test_group')->nullable()->after('promo_code_pattern');
            }
            if (! Schema::hasColumn('promotions', 'test_percentage')) {
                $table->decimal('test_percentage', 5, 2)->nullable()->after('test_group');
            }

            // Performance tracking
            if (! Schema::hasColumn('promotions', 'performance_metrics')) {
                $table->jsonb('performance_metrics')->nullable()->after('test_percentage');
            }
        });

        // Add indexes for performance if they don't exist
        try {
            Schema::table('promotions', function (Blueprint $table) {
                $table->index(['type', 'is_active']);
                $table->index(['product_discount_mode', 'discount_application']);
                $table->index(['start_date', 'end_date', 'is_active']);
                $table->index(['company_id', 'type', 'is_active']);
            });
        } catch (Exception $e) {
            // Indexes might already exist, ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn([
                'buy_get_mode',
                'buy_products',
                'get_products',
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
                'is_first_purchase_only',
                'product_discount_mode',
                'discount_application',
                'volume_tiers',
                'membership_levels',
                'seasonal_conditions',
                'usage_analytics',
                'customer_segments',
                'geographic_restrictions',
                'time_restrictions',
                'allow_combination',
                'combination_rules',
                'max_discount_per_item',
                'max_total_discount',
                'requires_code',
                'promo_code_pattern',
                'test_group',
                'test_percentage',
                'performance_metrics',
            ]);
        });
    }
};
