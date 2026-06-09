<?php

namespace Database\Seeders\CodeSystem\Observation;

use App\Models\Master\CodeSystem\Observation\MasterObservationCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OptimizedCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('seeders/csvs/tableConvert.com_ixsmxz.csv');

        if (!File::exists($file)) {
            $this->command->error("File $file tidak ditemukan.");
            return;
        }

        $this->command->info("🚀 Memulai optimized seeding...");
        $startTime = microtime(true);

        // Gunakan method tercepat yang tersedia
        if ($this->canUseLoadDataInfile()) {
            $this->loadDataInfile($file);
        } else {
            $this->bulkInsertOptimized($file);
        }

        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);
        $totalRecords = MasterObservationCode::count();

        $this->command->info("✅ Seeding selesai!");
        $this->command->info("⏱️  Waktu eksekusi: {$executionTime} detik");
        $this->command->info("📊 Total records: {$totalRecords}");
        $this->command->info("🏃 Speed: " . round($totalRecords / max($executionTime, 0.1), 2) . " records/detik");
    }

    /**
     * Check if LOAD DATA INFILE can be used
     */
    private function canUseLoadDataInfile(): bool
    {
        if (DB::getDriverName() !== 'mysql') {
            return false;
        }

        try {
            $result = DB::select("SHOW VARIABLES LIKE 'local_infile'");
            return !empty($result) && $result[0]->Value === 'ON';
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Fastest method for MySQL - LOAD DATA INFILE
     */
    private function loadDataInfile($file): void
    {
        $this->command->info("⚡ Menggunakan LOAD DATA INFILE (tercepat)...");

        $tableName = (new MasterObservationCode())->getTable();

        // Optimasi MySQL untuk import
        $this->optimizeDatabaseForImport();

        // Truncate table
        MasterObservationCode::truncate();

        $absolutePath = realpath($file);

        $sql = "
            LOAD DATA LOCAL INFILE ?
            INTO TABLE {$tableName}
            FIELDS TERMINATED BY ','
            OPTIONALLY ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (@code, @display)
            SET
                code = @code,
                display = @display,
                created_at = NOW(),
                updated_at = NOW()
        ";

        try {
            DB::statement($sql, [$absolutePath]);
            $this->command->info("✅ LOAD DATA INFILE berhasil!");
        } catch (\Exception $e) {
            $this->command->error("❌ LOAD DATA INFILE gagal: " . $e->getMessage());
            $this->command->info("🔄 Fallback ke bulk insert...");
            $this->bulkInsertOptimized($file);
            return;
        }

        // Restore MySQL settings
        $this->restoreDatabaseSettings();
    }

    /**
     * Optimized bulk insert method
     */
    private function bulkInsertOptimized($file): void
    {
        $this->command->info("📋 Menggunakan optimized bulk insert...");

        // Optimasi database berdasarkan driver
        $this->optimizeDatabaseForImport();

        // Disable Eloquent features untuk performa
        MasterObservationCode::unguard();

        // Truncate table
        MasterObservationCode::truncate();

        $chunkSize = $this->getOptimalChunkSize();
        $totalRows = 0;
        $dataChunk = [];

        // Hitung total baris untuk progress bar
        $totalLines = $this->countFileLines($file) - 1; // Exclude header
        $progressBar = $this->command->getOutput()->createProgressBar($totalLines);
        $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start();

        // Start transaction
        DB::beginTransaction();

        // Baca file dengan stream untuk efisiensi memory
        $handle = fopen($file, 'r');
        if (!$handle) {
            $this->command->error("Tidak bisa membuka file: {$file}");
            return;
        }

        // Skip header
        $header = array_map('trim', str_getcsv(fgets($handle)));

        $now = Carbon::now();
        $batchCount = 0;
        $orderCounter = 1; // Start order counter

        while (($line = fgets($handle)) !== false) {
            $row = str_getcsv($line);

            // Skip baris kosong atau tidak valid
            if (count($row) < 2) {
                $progressBar->advance();
                continue;
            }

            $data = array_combine($header, $row);

            $dataChunk[] = [
                'id' => Str::uuid()->toString(),
                'code'  => $data['LOINC_NUM'] ?? '',
                'display' => $data['LONG_COMMON_NAME'] ?? '',
                'order' => $orderCounter++, // Increment order for each record
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($dataChunk) >= $chunkSize) {
                $this->insertChunk($dataChunk, $batchCount);
                $totalRows += count($dataChunk);
                $progressBar->advance(count($dataChunk));

                $dataChunk = [];
                $batchCount++;

                // Commit setiap 10 batch untuk memory management
                if ($batchCount % 10 === 0) {
                    DB::commit();
                    DB::beginTransaction();
                }
            }
        }

        // Insert data terakhir
        if (!empty($dataChunk)) {
            $this->insertChunk($dataChunk, $batchCount);
            $totalRows += count($dataChunk);
            $progressBar->advance(count($dataChunk));
        }

        $progressBar->finish();
        $this->command->line('');

        fclose($handle);

        // Commit final transaction
        DB::commit();

        // Restore database settings
        $this->restoreDatabaseSettings();

        MasterObservationCode::reguard();

        $this->command->info("📊 Total {$totalRows} rows berhasil diimport dalam {$batchCount} batches.");
    }

    /**
     * Optimize database settings based on driver
     */
    private function optimizeDatabaseForImport(): void
    {
        $driver = DB::getDriverName();

        try {
            switch ($driver) {
                case 'mysql':
                    DB::statement('SET autocommit=0');
                    DB::statement('SET unique_checks=0');
                    DB::statement('SET foreign_key_checks=0');
                    DB::statement('SET sql_log_bin=0');
                    break;

                case 'pgsql':
                    // PostgreSQL optimizations (only session-level parameters)
                    $this->optimizePostgreSQL();
                    break;

                case 'sqlite':
                    // SQLite optimizations
                    DB::statement('PRAGMA synchronous = OFF');
                    DB::statement('PRAGMA journal_mode = MEMORY');
                    DB::statement('PRAGMA cache_size = 10000');
                    break;

                default:
                    // No specific optimization for other drivers
                    break;
            }
        } catch (\Exception $e) {
            // Silent fallback - don't show warnings for failed optimizations
        }
    }

    /**
     * PostgreSQL-specific optimizations with error handling
     */
    private function optimizePostgreSQL(): void
    {
        $optimizations = [
            'SET synchronous_commit TO OFF',
            'SET maintenance_work_mem TO "256MB"',
            'SET log_statement TO "none"',
            'SET log_min_duration_statement TO -1',
            'SET log_min_messages TO warning',
        ];

        foreach ($optimizations as $statement) {
            try {
                DB::statement($statement);
            } catch (\Exception $e) {
                // Silent ignore - some parameters might require server restart
                continue;
            }
        }
    }

    /**
     * Restore database settings
     */
    private function restoreDatabaseSettings(): void
    {
        $driver = DB::getDriverName();

        try {
            switch ($driver) {
                case 'mysql':
                    DB::statement('SET foreign_key_checks=1');
                    DB::statement('SET unique_checks=1');
                    DB::statement('SET autocommit=1');
                    DB::statement('SET sql_log_bin=1');
                    break;

                case 'pgsql':
                    // Restore PostgreSQL settings silently
                    $this->restorePostgreSQL();
                    break;

                case 'sqlite':
                    // Restore SQLite settings
                    DB::statement('PRAGMA synchronous = NORMAL');
                    DB::statement('PRAGMA journal_mode = DELETE');
                    break;

                default:
                    // No specific restoration needed
                    break;
            }
        } catch (\Exception $e) {
            // Silent restore - don't show warnings
        }
    }

    /**
     * PostgreSQL-specific restore with silent error handling
     */
    private function restorePostgreSQL(): void
    {
        $restoreStatements = [
            'SET synchronous_commit TO ON',
            'RESET maintenance_work_mem',
            'RESET log_statement',
            'RESET log_min_duration_statement',
            'RESET log_min_messages',
        ];

        foreach ($restoreStatements as $statement) {
            try {
                DB::statement($statement);
            } catch (\Exception $e) {
                // Silent ignore - some parameters might require server restart
                continue;
            }
        }
    }

    /**
     * Insert chunk dengan error handling
     */
    private function insertChunk(array $dataChunk, int $batchNumber): void
    {
        try {
            DB::table('master_observation_codes')->insert($dataChunk);
        } catch (\Exception $e) {
            $this->command->error("❌ Error pada batch {$batchNumber}: " . $e->getMessage());

            // Coba insert satu per satu untuk identify masalah
            foreach ($dataChunk as $index => $row) {
                try {
                    DB::table('master_observation_codes')->insert($row);
                } catch (\Exception $rowError) {
                    $this->command->warn("⚠️  Skipping row " . ($index + 1) . " in batch {$batchNumber}: " . $rowError->getMessage());
                }
            }
        }
    }

    /**
     * Determine optimal chunk size based on available memory
     */
    private function getOptimalChunkSize(): int
    {
        $memoryLimit = $this->getMemoryLimitInBytes();
        $availableMemory = $memoryLimit - memory_get_usage(true);

        // Estimasi: setiap row menggunakan sekitar 200 bytes
        $estimatedRowSize = 200;
        $optimalSize = (int) ($availableMemory * 0.1) / $estimatedRowSize; // Gunakan 10% memory

        // Batasi antara 500 - 10000
        return max(500, min(10000, $optimalSize));
    }

    /**
     * Get memory limit in bytes
     */
    private function getMemoryLimitInBytes(): int
    {
        $memoryLimit = ini_get('memory_limit');

        if ($memoryLimit === '-1') {
            return PHP_INT_MAX; // Unlimited
        }

        $unit = strtolower(substr($memoryLimit, -1));
        $value = (int) substr($memoryLimit, 0, -1);

        switch ($unit) {
            case 'g':
                return $value * 1024 * 1024 * 1024;
            case 'm':
                return $value * 1024 * 1024;
            case 'k':
                return $value * 1024;
            default:
                return (int) $memoryLimit;
        }
    }

    /**
     * Count total lines in file efficiently
     */
    private function countFileLines($file): int
    {
        $lines = 0;
        $handle = fopen($file, 'r');

        if (!$handle) {
            return 0;
        }

        while (!feof($handle)) {
            if (fgets($handle) !== false) {
                $lines++;
            }
        }

        fclose($handle);
        return $lines;
    }
}
