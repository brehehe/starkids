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
        Schema::create('user_type_incentives', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_type_id')->constrained('user_types')->onDelete('cascade');
            $table->decimal('price_min', 15, 2)->default(0); // Harga minimum range
            $table->decimal('price_max', 15, 2)->nullable(); // Harga maksimum range (nullable untuk unlimited)
            $table->decimal('incentive_value', 15, 2)->default(0); // Nilai insentif
            $table->enum('incentive_type', ['persen', 'rupiah'])->default('rupiah'); // Tipe insentif: persen atau rupiah
            $table->string('description')->nullable(); // Deskripsi range
            $table->boolean('is_active')->default(true); // Status aktif
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
        Schema::dropIfExists('user_type_incentives');
    }
};
