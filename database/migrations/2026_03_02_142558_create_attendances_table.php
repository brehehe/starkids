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
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->nullable();
            $table->foreignUuid('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('date');
            $table->time('clock_in_time')->nullable();
            $table->decimal('clock_in_location_lat', 10, 8)->nullable();
            $table->decimal('clock_in_location_long', 11, 8)->nullable();
            $table->string('clock_in_photo_path')->nullable();
            $table->time('clock_out_time')->nullable();
            $table->decimal('clock_out_location_lat', 10, 8)->nullable();
            $table->decimal('clock_out_location_long', 11, 8)->nullable();
            $table->string('clock_out_photo_path')->nullable();
            $table->string('status')->default('present'); // present, late, absent, left_early
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
        Schema::dropIfExists('attendances');
    }
};
