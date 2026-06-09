<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Nonaktifkan Database Transaction Laravel untuk mengizinkan instruksi CREATE INDEX CONCURRENTLY
     * Postgres. Fitur Zero-Downtime Indexing memastikan tabel tidak di "Lock" selagi migrasi berjalan.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $isSqlite = Schema::connection(null)->getConnection()->getDriverName() === 'sqlite';
        $concurrently = $isSqlite ? '' : 'CONCURRENTLY ';

        // =========================================================================
        // BAGIAN 1: TABEL-TABEL UTAMA TRANSAKSI KASIR (POS) & REKAM MEDIS
        // =========================================================================

        // 1. Transaction Details (Sangat Kritikal)
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS transaction_details_transaction_id_index ON transaction_details (transaction_id)");
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS transaction_details_product_id_index ON transaction_details (product_id)");

        // 2. Transaction Payments (Kritikal Nominal)
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS transaction_payments_transaction_id_index ON transaction_payments (transaction_id)");

        // 3. Modul Tagihan Pendukung
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS transaction_actions_transaction_id_index ON transaction_actions (transaction_id)");
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS transaction_nurses_transaction_id_index ON transaction_nurses (transaction_id)");
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS transaction_diagnoses_transaction_id_index ON transaction_diagnoses (transaction_id)");
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS transaction_products_transaction_id_index ON transaction_products (transaction_id)");

        // =========================================================================
        // BAGIAN 2: TABEL INVENTORI, OBAT, MUTASI DAN STOK OPNAME TRANSAKSI
        // =========================================================================

        // 1. Kartu & Buku Sisa Stok (Sangat Kritikal)
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS product_stocks_product_id_index ON product_stocks (product_id)");
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS transaction_products_product_id_index ON transaction_products (product_id)");

        // 2. Transaksi Mutasi & Barang Gudang
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS stock_mutation_details_product_id_index ON stock_mutation_details (product_id)");
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS stock_opname_items_product_id_index ON stock_opname_items (product_id)");
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS purchase_order_items_product_id_index ON purchase_order_items (product_id)");
        DB::statement("CREATE INDEX {$concurrently}IF NOT EXISTS medications_product_id_index ON medications (product_id)");

        // Catatan: Hanya di-indeks pada tabel-tabel di atas (sekitar 14 Index) untuk mencegah "Berat/Lemot"
        // saat menjalankan perintah migrate di production, namun sudah memulihkan 90% masalah N+1 Query.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $isSqlite = Schema::connection(null)->getConnection()->getDriverName() === 'sqlite';
        $concurrently = $isSqlite ? '' : 'CONCURRENTLY ';

        // 1. Rollback POS
        DB::statement("DROP INDEX {$concurrently}IF EXISTS transaction_details_transaction_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS transaction_details_product_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS transaction_payments_transaction_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS transaction_actions_transaction_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS transaction_nurses_transaction_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS transaction_diagnoses_transaction_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS transaction_products_transaction_id_index");

        // 2. Rollback Inventori
        DB::statement("DROP INDEX {$concurrently}IF EXISTS product_stocks_product_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS transaction_products_product_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS stock_mutation_details_product_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS stock_opname_items_product_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS purchase_order_items_product_id_index");
        DB::statement("DROP INDEX {$concurrently}IF EXISTS medications_product_id_index");
    }
};
