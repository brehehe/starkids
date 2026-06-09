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
        // For PostgreSQL, we need to:
        // 1. Drop the old constraints first (to allow data updates)
        // 2. Update existing data
        // 3. Add new constraints with 'persen' instead of 'percentage'

        // Step 1: Drop old constraints
        DB::statement("ALTER TABLE products DROP CONSTRAINT IF EXISTS products_type_incentive_nurse_check");
        DB::statement("ALTER TABLE products DROP CONSTRAINT IF EXISTS products_type_incentive_doctor_check");

        // Step 2: Update existing 'percentage' values to 'persen'
        DB::statement("UPDATE products SET type_incentive_nurse = 'persen' WHERE type_incentive_nurse = 'percentage'");
        DB::statement("UPDATE products SET type_incentive_doctor = 'persen' WHERE type_incentive_doctor = 'percentage'");

        // Step 3: Add new constraints with updated enum values
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_type_incentive_nurse_check CHECK (type_incentive_nurse IN ('persen', 'rupiah'))");
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_type_incentive_doctor_check CHECK (type_incentive_doctor IN ('persen', 'rupiah'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse: change 'persen' back to 'percentage'
        DB::statement("UPDATE products SET type_incentive_nurse = 'percentage' WHERE type_incentive_nurse = 'persen'");
        DB::statement("UPDATE products SET type_incentive_doctor = 'percentage' WHERE type_incentive_doctor = 'persen'");

        // Drop constraints
        DB::statement("ALTER TABLE products DROP CONSTRAINT IF EXISTS products_type_incentive_nurse_check");
        DB::statement("ALTER TABLE products DROP CONSTRAINT IF EXISTS products_type_incentive_doctor_check");

        // Add old constraints back
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_type_incentive_nurse_check CHECK (type_incentive_nurse IN ('percentage', 'rupiah'))");
        DB::statement("ALTER TABLE products ADD CONSTRAINT products_type_incentive_doctor_check CHECK (type_incentive_doctor IN ('percentage', 'rupiah'))");
    }
};
