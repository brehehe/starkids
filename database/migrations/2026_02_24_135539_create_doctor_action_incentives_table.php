<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_action_incentives', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relasi ke tindakan (products dengan is_non_stock = true / type = Tindakan)
            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();

            // user_id = doctor's user_id (konsisten dengan transactions.doctor_id → users.id)
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();

            // Tipe insentif: percentage atau rupiah
            $table->enum('type_incentive', ['percentage', 'rupiah'])->default('rupiah');

            // Nilai insentif (persen atau nominal rupiah)
            $table->decimal('incentive_value', 15, 2)->default(0);

            $table->foreignUuid('company_id')->nullable()->constrained('companies')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();

            // Satu dokter hanya bisa punya satu catatan insentif per tindakan
            $table->unique(['product_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_action_incentives');
    }
};
