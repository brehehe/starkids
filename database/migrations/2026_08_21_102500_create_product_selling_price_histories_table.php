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
        Schema::create('product_selling_price_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->index();
            $table->foreignUuid('product_price_id')->nullable();
            $table->foreignUuid('user_id')->nullable();
            $table->foreignUuid('branch_id')->nullable();
            $table->foreignUuid('company_id')->index();
            $table->decimal('old_price', 15, 2)->default(0);
            $table->decimal('new_price', 15, 2)->default(0);
            $table->decimal('old_recipe', 15, 2)->default(0);
            $table->decimal('new_recipe', 15, 2)->default(0);
            $table->decimal('old_hpp_average', 15, 2)->default(0);
            $table->decimal('new_hpp_average', 15, 2)->default(0);
            $table->string('source')->nullable(); // e.g. 'Penyesuaian Manual', 'Generate Margin', 'Master Produk'
            $table->text('notes')->nullable();
            $table->bigInteger('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_selling_price_histories');
    }
};
