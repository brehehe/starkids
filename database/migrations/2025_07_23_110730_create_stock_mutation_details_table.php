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
        Schema::create('stock_mutation_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('stock_mutation_id');
            $table->foreignUuid('product_id');
            $table->foreignUuid('product_branch_id');
            $table->string('product_name');
            $table->decimal('quantity_system', 15, 2)->default(0);
            $table->decimal('quantity', 15, 2)->default(0);
            $table->foreignUuid('company_id')->nullable();
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
        Schema::dropIfExists('stock_mutation_details');
    }
};
