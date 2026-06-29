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
        Schema::create('deposits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->foreignUuid('patient_id')->nullable();
            $table->foreignUuid('user_type_id')->nullable();
            $table->foreignUuid('patient_company_role_id')->nullable();
            $table->string('text')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('quantity_request', 15, 0);
            $table->decimal('quantity_free', 15, 0);
            $table->decimal('quantity', 15, 0);
            $table->decimal('remaining_quantity', 15, 0);
            $table->decimal('sub_total_price', 15, 2);
            $table->decimal('rounding', 15, 2)->nullable();
            $table->decimal('grand_total_price', 15, 2);
            $table->decimal('remaining_bill', 15, 2);
            $table->decimal('payment_change', 15, 2);
            $table->enum('status', ['waiting', 'partial', 'success']);
            $table->foreignUuid('created_by')->nullable();
            $table->foreignUuid('branch_id')->nullable();
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
        Schema::dropIfExists('deposits');
    }
};
