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
        Schema::create('promotions_simplified', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Basic Information
            $table->string('name');
            $table->string('code')->unique();
            $table->longText('description')->nullable();

            // Promotion Type - Simplified to 4 main types
            $table->enum('type', ['discount', 'buy_x_get_y', 'bundle', 'special']);

            // Discount Configuration (for type = 'discount')
            $table->enum('discount_type', ['percentage', 'fixed', 'fixed_price'])->nullable();
            $table->decimal('discount_value', 15, 2)->default(0);
            $table->decimal('max_discount', 15, 2)->nullable(); // For percentage discount
            $table->decimal('minimum_purchase', 15, 2)->default(0);

            // Buy X Get Y Configuration (for type = 'buy_x_get_y')
            $table->integer('buy_quantity')->default(1);
            $table->integer('get_quantity')->default(1);
            $table->uuid('buy_product_id')->nullable(); // Specific product to buy
            $table->uuid('get_product_id')->nullable(); // Specific product to get for free

            // Bundle Configuration (for type = 'bundle')
            $table->decimal('bundle_price', 15, 2)->default(0);
            $table->jsonb('bundle_products')->nullable(); // Array of {product_id, quantity}

            // Special Promotion Configuration (for type = 'special')
            $table->enum('special_type', ['cashback', 'free_shipping', 'loyalty_points'])->nullable();
            $table->decimal('cashback_percentage', 5, 2)->default(0);
            $table->decimal('max_cashback', 15, 2)->nullable();
            $table->decimal('free_shipping_min', 15, 2)->default(0);
            $table->decimal('points_multiplier', 5, 2)->default(1);

            // Targeting & Conditions
            $table->enum('target_type', ['all', 'products', 'users', 'companies'])->default('all');
            $table->jsonb('selected_products')->nullable(); // Array of product IDs
            $table->jsonb('selected_users')->nullable(); // Array of user IDs
            $table->jsonb('selected_companies')->nullable(); // Array of company IDs

            // Time & Schedule
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->jsonb('applicable_days')->nullable(); // ['monday', 'tuesday', ...]

            // Quota & Usage
            $table->integer('total_quota')->default(0);
            $table->integer('quota_per_user')->default(1);
            $table->integer('used_count')->default(0); // How many times used
            $table->boolean('is_unlimited')->default(true);

            // Status & Display
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(1);
            $table->string('banner_text')->nullable();
            $table->longText('image')->nullable(); // Image path

            // Audit
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->foreignUuid('company_id')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Indexes for performance
            $table->index(['code', 'company_id']);
            $table->index(['is_active', 'start_date', 'end_date']);
            $table->index(['type', 'target_type']);
            $table->index(['company_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions_simplified');
    }
};
