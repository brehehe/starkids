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
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignUuid('promotion_simplified_id')->nullable();
            $table->decimal('promotion_real', 15, 2)->default(0);
            $table->decimal('promotion', 15, 2)->default(0);
            $table->enum('promotion_type', ['rupiah', 'percentage'])->default('rupiah');
            $table->decimal('promotion_value', 15, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'promotion_simplified_id',
                'promotion_real',
                'promotion',
                'promotion_type',
                'promotion_value'
            ]);
        });
    }
};
