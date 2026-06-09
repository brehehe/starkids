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
        Schema::create('employee_payroll_components', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('employee_payroll_id')->constrained('employee_payrolls')->onDelete('cascade');
            $table->foreignUuid('payroll_component_id')->constrained('payroll_components')->onDelete('cascade');
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_payroll_components');
    }
};
