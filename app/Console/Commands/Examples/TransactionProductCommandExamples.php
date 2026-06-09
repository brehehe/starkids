<?php

/**
 * Contoh Script untuk Testing Command GenerateTransactionProductReport
 *
 * File ini berisi contoh-contoh praktis penggunaan command
 */

namespace App\Console\Commands\Examples;

class TransactionProductCommandExamples
{
    /**
     * Contoh 1: Generate untuk semua data (gunakan dengan hati-hati!)
     */
    public function example1_generateAll()
    {
        // PERINGATAN: Jangan jalankan ini di production tanpa test dry-run dulu!

        echo "=== EXAMPLE 1: Generate All Data ===\n";
        echo "Command: php artisan report:transaction-product --dry-run\n";
        echo "Description: Preview semua data yang akan diproses\n\n";

        echo "Setelah yakin dengan dry-run, jalankan:\n";
        echo "Command: php artisan report:transaction-product\n\n";
    }

    /**
     * Contoh 2: Generate untuk transaksi spesifik
     */
    public function example2_specificTransaction()
    {
        echo "=== EXAMPLE 2: Specific Transaction ===\n";
        echo "Command: php artisan report:transaction-product --transaction_id=01234567-89ab-cdef-0123-456789abcdef\n";
        echo "Description: Generate TransactionProduct untuk satu transaksi saja\n";
        echo "Use case: Fix missing TransactionProduct untuk transaksi tertentu\n\n";
    }

    /**
     * Contoh 3: Generate untuk company dan periode tertentu
     */
    public function example3_companyAndDateRange()
    {
        echo "=== EXAMPLE 3: Company & Date Range ===\n";
        echo "Command: php artisan report:transaction-product --company_id=company-uuid --start_date=2025-01-01 --end_date=2025-01-31\n";
        echo "Description: Generate untuk satu company dalam periode Januari 2025\n";
        echo "Use case: Migrasi data per company secara bertahap\n\n";
    }

    /**
     * Contoh 4: Testing dan debugging
     */
    public function example4_testingAndDebugging()
    {
        echo "=== EXAMPLE 4: Testing & Debugging ===\n";
        echo "1. Dry run untuk preview:\n";
        echo "   php artisan report:transaction-product --dry-run --start_date=2025-01-01 --end_date=2025-01-07\n\n";

        echo "2. Process small batch untuk test:\n";
        echo "   php artisan report:transaction-product --start_date=2025-01-01 --end_date=2025-01-01\n\n";

        echo "3. Check hasil dengan query:\n";
        echo "   SELECT COUNT(*) FROM transaction_products WHERE DATE(created_at) = '2025-01-01'\n\n";
    }

    /**
     * Contoh 5: Force recreate existing data
     */
    public function example5_forceRecreate()
    {
        echo "=== EXAMPLE 5: Force Recreate ===\n";
        echo "Command: php artisan report:transaction-product --force --transaction_id=specific-id\n";
        echo "Description: Hapus dan buat ulang TransactionProduct yang sudah ada\n";
        echo "Use case: Fix data yang salah atau ada perubahan logic perhitungan\n\n";

        echo "PERINGATAN: Backup data dulu!\n";
        echo "mysqldump mediction transaction_products > backup_before_force.sql\n\n";
    }

    /**
     * Contoh 6: Batch processing untuk data besar
     */
    public function example6_batchProcessing()
    {
        echo "=== EXAMPLE 6: Batch Processing ===\n";
        echo "Untuk data besar, proses per minggu atau bulan:\n\n";

        $months = [
            '2025-01-01' => '2025-01-31',
            '2025-02-01' => '2025-02-28',
            '2025-03-01' => '2025-03-31',
        ];

        foreach ($months as $start => $end) {
            echo "php artisan report:transaction-product --start_date={$start} --end_date={$end}\n";
        }
        echo "\n";
    }

    /**
     * Contoh 7: Monitoring dan logging
     */
    public function example7_monitoringAndLogging()
    {
        echo "=== EXAMPLE 7: Monitoring & Logging ===\n";
        echo "1. Run dengan verbose output:\n";
        echo "   php artisan report:transaction-product --start_date=2025-01-01 --end_date=2025-01-31 -v\n\n";

        echo "2. Redirect output ke file:\n";
        echo "   php artisan report:transaction-product --start_date=2025-01-01 --end_date=2025-01-31 > output.log 2>&1\n\n";

        echo "3. Check Laravel log:\n";
        echo "   tail -f storage/logs/laravel.log | grep 'TransactionProduct'\n\n";
    }

    /**
     * Contoh 8: Validasi hasil
     */
    public function example8_validateResults()
    {
        echo "=== EXAMPLE 8: Validate Results ===\n";
        echo "Query untuk validasi hasil:\n\n";

        echo "1. Count TransactionProduct vs TransactionRecipe:\n";
        echo "SELECT \n";
        echo "  (SELECT COUNT(*) FROM transaction_recipes WHERE product_id IS NOT NULL AND quantity > 0) as recipe_count,\n";
        echo "  (SELECT COUNT(*) FROM transaction_products WHERE transaction_recipe_id IS NOT NULL) as product_recipe_count\n\n";

        echo "2. Count TransactionProduct vs TransactionDetail:\n";
        echo "SELECT \n";
        echo "  (SELECT COUNT(*) FROM transaction_details WHERE product_id IS NOT NULL AND quantity > 0) as detail_count,\n";
        echo "  (SELECT COUNT(*) FROM transaction_products WHERE transaction_detail_id IS NOT NULL) as product_detail_count\n\n";

        echo "3. Check data integrity:\n";
        echo "SELECT tp.*, tr.quantity as recipe_qty, td.quantity as detail_qty\n";
        echo "FROM transaction_products tp\n";
        echo "LEFT JOIN transaction_recipes tr ON tp.transaction_recipe_id = tr.id\n";
        echo "LEFT JOIN transaction_details td ON tp.transaction_detail_id = td.id\n";
        echo "WHERE tp.quantity != COALESCE(tr.quantity, td.quantity, 0)\n";
        echo "LIMIT 10\n\n";
    }

    /**
     * Script lengkap untuk migrasi data
     */
    public function fullMigrationScript()
    {
        echo "=== FULL MIGRATION SCRIPT ===\n";
        echo "#!/bin/bash\n\n";

        echo "# 1. Backup existing data\n";
        echo "echo 'Creating backup...'\n";
        echo "mysqldump mediction transaction_products > backup_transaction_products_$(date +%Y%m%d_%H%M%S).sql\n\n";

        echo "# 2. Test with dry run\n";
        echo "echo 'Testing with dry run...'\n";
        echo "php artisan report:transaction-product --dry-run --start_date=2025-01-01 --end_date=2025-01-07\n\n";

        echo "# 3. Process small batch first\n";
        echo "echo 'Processing small batch...'\n";
        echo "php artisan report:transaction-product --start_date=2025-01-01 --end_date=2025-01-07\n\n";

        echo "# 4. Validate results\n";
        echo "echo 'Validating results...'\n";
        echo "mysql -e \"SELECT COUNT(*) as created_records FROM mediction.transaction_products WHERE DATE(created_at) BETWEEN '2025-01-01' AND '2025-01-07'\"\n\n";

        echo "# 5. If validation OK, process full range\n";
        echo "echo 'Processing full range...'\n";
        echo "php artisan report:transaction-product --start_date=2025-01-01 --end_date=2025-12-31\n\n";

        echo "# 6. Final validation\n";
        echo "echo 'Final validation...'\n";
        echo "mysql -e \"SELECT COUNT(*) as total_records FROM mediction.transaction_products\"\n\n";

        echo "echo 'Migration completed!'\n\n";
    }

    /**
     * Troubleshooting common issues
     */
    public function troubleshooting()
    {
        echo "=== TROUBLESHOOTING ===\n\n";

        echo "1. Memory limit error:\n";
        echo "   php -d memory_limit=1G artisan report:transaction-product\n\n";

        echo "2. Timeout error:\n";
        echo "   php -d max_execution_time=0 artisan report:transaction-product\n\n";

        echo "3. Missing ProductPrice:\n";
        echo "   Check log for products without HPP data\n";
        echo "   Query: SELECT DISTINCT product_id FROM transaction_recipes WHERE product_id NOT IN (SELECT product_id FROM product_prices)\n\n";

        echo "4. Duplicate key error:\n";
        echo "   Use --force to recreate existing records\n";
        echo "   Or check for duplicate transaction_recipe_id/transaction_detail_id\n\n";

        echo "5. Permission error:\n";
        echo "   Check database permissions for INSERT\n";
        echo "   Check storage/logs permission for logging\n\n";
    }

    /**
     * Performance optimization tips
     */
    public function performanceOptimization()
    {
        echo "=== PERFORMANCE OPTIMIZATION ===\n\n";

        echo "1. Database indexes:\n";
        echo "   CREATE INDEX idx_tp_transaction_recipe ON transaction_products(transaction_id, transaction_recipe_id, product_id);\n";
        echo "   CREATE INDEX idx_tp_transaction_detail ON transaction_products(transaction_id, transaction_detail_id, product_id);\n\n";

        echo "2. Query optimization:\n";
        echo "   Command menggunakan eager loading untuk relations\n";
        echo "   Process in chunks untuk memory efficiency\n\n";

        echo "3. Resource monitoring:\n";
        echo "   Monitor memory usage: top -p $(pgrep php)\n";
        echo "   Monitor disk space: df -h\n";
        echo "   Monitor database load: mysqladmin processlist\n\n";
    }
}

// Untuk menjalankan examples, bisa panggil static method:
// php artisan tinker
// App\Console\Commands\Examples\TransactionProductCommandExamples::example1_generateAll();
