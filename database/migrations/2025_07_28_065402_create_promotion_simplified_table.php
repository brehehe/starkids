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
        Schema::create('promotion_simplified', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('code')->unique();
            $table->enum('type', ['discount', 'buy_x_get_y', 'bundle', 'special', 'discount_product']);

            // Discount promotion fields
            $table->enum('discount_type', ['percentage', 'fixed', 'fixed_price'])->nullable();
            $table->decimal('discount_value', 12, 2)->nullable();
            $table->decimal('max_discount', 12, 2)->nullable();

            // Buy X Get Y promotion fields
            $table->integer('buy_quantity')->nullable();
            $table->integer('get_quantity')->nullable();

            // Bundle promotion fields
            $table->decimal('bundle_price', 12, 2)->nullable();
            $table->jsonb('bundle_products')->nullable();

            // Special promotion fields
            $table->enum('special_type', ['cashback', 'free_shipping', 'loyalty_points'])->nullable();
            $table->decimal('cashback_percentage', 5, 2)->nullable();
            $table->integer('points_multiplier')->nullable();

            // General promotion settings
            $table->decimal('minimum_purchase', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_unlimited')->default(false);
            $table->integer('total_quota')->nullable();
            $table->integer('quota_per_user')->default(1);
            $table->integer('used_count')->default(0);

            // Date and time settings
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->jsonb('applicable_days')->nullable(); // ['monday', 'tuesday', etc]

            // Targeting
            $table->jsonb('applicable_products')->nullable();
            $table->jsonb('applicable_users')->nullable();
            $table->jsonb('applicable_user_types')->nullable();
            $table->jsonb('applicable_companies')->nullable();

            // Terms and conditions
            $table->jsonb('terms_conditions')->nullable();

            // Additional settings
            $table->boolean('is_featured')->default(false);
            $table->boolean('can_combine_with_other')->default(false);

            $table->enum('schedule_type', [
                'always',
                'specific_days',
                'days_only',
                'time_only',
                'days_and_time',
            ])->default('always');
            $table->jsonb('specific_days')->nullable();
            $table->time('specific_start_time')->nullable();
            $table->time('specific_end_time')->nullable();
            $table->boolean('apply_time_to_days')->default(false);

            $table->jsonb('buy_x_get_y_rules')->nullable();
            $table->jsonb('discount_products')->nullable();

            $table->bigInteger('order')->default(0);
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['company_id', 'is_active']);
            $table->index(['code', 'company_id']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_simplified');
    }
};
