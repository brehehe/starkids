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
        Schema::table('promotions_simplified', function (Blueprint $table) {
            $table->json('buy_x_get_y_rules')->nullable()->after('applicable_days');
            $table->json('discount_products')->nullable()->after('buy_x_get_y_rules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotions_simplified', function (Blueprint $table) {
            $table->dropColumn(['buy_x_get_y_rules', 'discount_products']);
        });
    }
};
