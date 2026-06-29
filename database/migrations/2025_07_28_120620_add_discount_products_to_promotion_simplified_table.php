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
        Schema::table('promotion_simplified', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (! Schema::hasColumn('promotion_simplified', 'discount_products')) {
                $table->json('discount_products')->nullable()->comment('Array of discount products configuration');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotion_simplified', function (Blueprint $table) {
            if (Schema::hasColumn('promotion_simplified', 'discount_products')) {
                $table->dropColumn('discount_products');
            }
        });
    }
};
