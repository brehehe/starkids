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
        Schema::create('promotion_usages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->foreignUuid('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignUuid('transaction_id')->nullable()->constrained('transactions')->onDelete('set null');
            $table->decimal('discount_amount', 15, 2)->default(0); // Jumlah potongan yang diberikan
            $table->decimal('original_amount', 15, 2)->default(0); // Jumlah asli sebelum diskon
            $table->decimal('final_amount', 15, 2)->default(0); // Jumlah setelah diskon
            $table->jsonb('applied_products')->nullable(); // Produk yang terkena diskon
            $table->string('promotion_code'); // Kode promo yang digunakan
            $table->timestamp('used_at');
            $table->string('status')->default('active'); // active, cancelled, refunded
            $table->text('notes')->nullable();
            $table->foreignUuid('company_id')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['promotion_id', 'user_id']);
            $table->index(['promotion_code', 'company_id']);
            $table->index(['used_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_usages');
    }
};
