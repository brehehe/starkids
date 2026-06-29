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
        Schema::create('promotion_usage_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('promotion_id');
            $table->uuid('customer_id');
            $table->uuid('order_id')->nullable(); // ID transaksi/order

            $table->decimal('order_amount', 15, 2); // Total order
            $table->decimal('discount_amount', 15, 2); // Potongan yang didapat
            $table->json('applied_products')->nullable(); // Produk yang terkena promosi

            $table->datetime('used_at');
            $table->timestamps();

            // Indexes dan Foreign Keys
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->index(['promotion_id', 'customer_id']);
            $table->index('used_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_usage_histories');
    }
};
