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
        Schema::create('promotions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code')->unique(); // Kode promo harus unique
            $table->longText('description')->nullable();
            $table->enum('promotion_scope', ['private', 'public', 'bundle'])->default('public');
            $table->enum('type', [
                'percentage',
                'fixed_amount',
                'buy_x_get_y',
                'free_shipping',
                'bundle',
                'cashback',
                'loyalty_points',
                'minimum_purchase_discount',
                'tier_discount',
                'product_specific',
                'category_discount',
                'first_time_buyer',
                'volume_discount',
                'membership_discount',
                'seasonal_discount'
            ]);
            $table->enum('promotion_type', ['persen', 'rupiah'])->default('persen');
            $table->decimal('promotion_value', 15, 2)->nullable(); // Nilai potongan
            $table->decimal('max_discount', 15, 2)->nullable(); // Maksimal potongan (untuk persen)
            $table->decimal('minimum_purchase', 15, 2)->default(0); // Minimal pembelian
            $table->decimal('maximum_purchase', 15, 2)->nullable(); // Maksimal pembelian (opsional)
            $table->integer('buy_quantity')->nullable(); // Untuk buy X get Y
            $table->integer('get_quantity')->nullable(); // Untuk buy X get Y
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('total_quota')->default(0); // Total kuota penggunaan
            $table->integer('quota_per_user')->default(0); // Kuota per user
            $table->integer('used_count')->default(0); // Sudah digunakan berapa kali
            $table->boolean('is_unlimited')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_stackable')->default(false); // Bisa dikombinasi dengan promo lain
            $table->boolean('is_auto_apply')->default(false); // Otomatis diaplikasikan
            $table->jsonb('applicable_days')->nullable(); // Hari berlaku: ['monday', 'tuesday', ...]
            $table->time('start_time')->nullable(); // Jam mulai berlaku
            $table->time('end_time')->nullable(); // Jam selesai berlaku
            $table->jsonb('user_types')->nullable(); // ID user types yang bisa menggunakan
            $table->jsonb('user_ids')->nullable(); // ID users spesifik yang bisa menggunakan
            $table->jsonb('product_ids')->nullable(); // ID produk yang berlaku promo
            $table->jsonb('company_ids')->nullable(); // ID perusahaan yang berlaku
            $table->jsonb('exclude_product_ids')->nullable(); // Produk yang dikecualikan
            $table->jsonb('terms_conditions')->nullable(); // Syarat dan ketentuan detail
            $table->longText('image')->nullable(); // Gambar promosi
            $table->string('banner_text')->nullable(); // Text untuk banner promo
            $table->integer('priority')->default(0); // Prioritas promo (semakin tinggi semakin prioritas)
            $table->string('created_by')->nullable(); // User yang membuat
            $table->string('updated_by')->nullable(); // User yang update terakhir
            $table->foreignUuid('company_id')->nullable();
            $table->bigInteger('order')->default(0);
            $table->softDeletes();
            $table->timestamps();

            // Indexes untuk performance
            $table->index(['code', 'company_id']);
            $table->index(['is_active', 'start_date', 'end_date']);
            $table->index(['type', 'promotion_scope']);
            $table->index(['company_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
