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
        Schema::create('promotion_usage', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('promotion_id');
            $table->foreignUuid('user_id')->nullable();
            $table->foreignUuid('company_id')->nullable();
            $table->decimal('amount_used', 12, 2)->nullable();
            $table->dateTime('used_at');
            $table->timestamps();

            // Indexes
            $table->index(['promotion_id', 'user_id']);
            $table->index(['promotion_id', 'used_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_usage');
    }
};
