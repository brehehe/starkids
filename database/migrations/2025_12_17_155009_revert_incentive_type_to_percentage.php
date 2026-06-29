<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Revert back to 'percentage' as requested

        if (Schema::connection(null)->getConnection()->getDriverName() !== 'sqlite') {
            // Step 1: Drop old constraints
            DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_type_incentive_nurse_check');
            DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_type_incentive_doctor_check');

            // Step 2: Update existing 'persen' values to 'percentage'
            DB::statement("UPDATE products SET type_incentive_nurse = 'percentage' WHERE type_incentive_nurse = 'persen'");
            DB::statement("UPDATE products SET type_incentive_doctor = 'percentage' WHERE type_incentive_doctor = 'persen'");

            // Step 3: Add new constraints with 'percentage'
            DB::statement("ALTER TABLE products ADD CONSTRAINT products_type_incentive_nurse_check CHECK (type_incentive_nurse IN ('percentage', 'rupiah'))");
            DB::statement("ALTER TABLE products ADD CONSTRAINT products_type_incentive_doctor_check CHECK (type_incentive_doctor IN ('percentage', 'rupiah'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::connection(null)->getConnection()->getDriverName() !== 'sqlite') {
            // Reverse: change 'percentage' back to 'persen'
            DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_type_incentive_nurse_check');
            DB::statement('ALTER TABLE products DROP CONSTRAINT IF EXISTS products_type_incentive_doctor_check');

            DB::statement("UPDATE products SET type_incentive_nurse = 'persen' WHERE type_incentive_nurse = 'percentage'");
            DB::statement("UPDATE products SET type_incentive_doctor = 'persen' WHERE type_incentive_doctor = 'percentage'");

            DB::statement("ALTER TABLE products ADD CONSTRAINT products_type_incentive_nurse_check CHECK (type_incentive_nurse IN ('persen', 'rupiah'))");
            DB::statement("ALTER TABLE products ADD CONSTRAINT products_type_incentive_doctor_check CHECK (type_incentive_doctor IN ('persen', 'rupiah'))");
        }
    }
};
