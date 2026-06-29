<?php

namespace Database\Seeders\Icd;

use App\Models\Icd\Icd10;
use App\Models\Icd\Icd9;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class IcdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai optimized ICD seeding...');
        $startTime = microtime(true);

        // Seed ICD9
        $this->seedIcd9Optimized();

        // Seed ICD10
        $this->seedIcd10Optimized();

        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);
        $totalIcd9 = Icd9::count();
        $totalIcd10 = Icd10::count();
        $totalRecords = $totalIcd9 + $totalIcd10;

        $this->command->info('✅ Seeding selesai!');
        $this->command->info("⏱️  Waktu eksekusi: {$executionTime} detik");
        $this->command->info("📊 Total ICD9 records: {$totalIcd9}");
        $this->command->info("📊 Total ICD10 records: {$totalIcd10}");
        $this->command->info("📊 Total records: {$totalRecords}");
        $this->command->info('🏃 Speed: '.round($totalRecords / max($executionTime, 0.1), 2).' records/detik');
    }

    /**
     * Optimized ICD9 seeding
     */
    private function seedIcd9Optimized(): void
    {
        $file = database_path('seeders/csvs/icd9.csv');

        if (! File::exists($file)) {
            $this->command->error("File $file tidak ditemukan.");

            return;
        }

        $this->command->info('📋 Memulai import ICD9...');

        // Optimasi database
        $this->optimizeDatabaseForImport();

        // Truncate table
        Icd9::truncate();

        $chunkSize = $this->getOptimalChunkSize();
        $dataChunk = [];
        $orderCounter = 1;
        $now = Carbon::now();

        // Hitung total baris untuk progress bar
        $totalLines = $this->countFileLines($file) - 1; // Exclude header
        $progressBar = $this->command->getOutput()->createProgressBar($totalLines);
        $progressBar->setFormat(' ICD9: %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start();

        // Start transaction
        DB::beginTransaction();

        // Baca file dengan stream
        $handle = fopen($file, 'r');
        $header = array_map('trim', str_getcsv(fgets($handle))); // Skip header

        $batchCount = 0;
        $totalRows = 0;

        while (($line = fgets($handle)) !== false) {
            $row = str_getcsv($line);

            if (count($row) < 3) {
                $progressBar->advance();

                continue;
            }

            $data = array_combine($header, $row);

            $dataChunk[] = [
                'id' => Str::uuid()->toString(),
                'code' => $data['CODE'] ?? '',
                'display' => $data['DISPLAY'] ?? '',
                'version' => $data['VERSION'] ?? '',
                'order' => $orderCounter++,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($dataChunk) >= $chunkSize) {
                $this->insertChunk('icd9s', $dataChunk, $batchCount, 'ICD9');
                $totalRows += count($dataChunk);
                $progressBar->advance(count($dataChunk));

                $dataChunk = [];
                $batchCount++;

                // Commit setiap 10 batch
                if ($batchCount % 10 === 0) {
                    DB::commit();
                    DB::beginTransaction();
                }
            }
        }

        // Insert data terakhir
        if (! empty($dataChunk)) {
            $this->insertChunk('icd9s', $dataChunk, $batchCount, 'ICD9');
            $totalRows += count($dataChunk);
            $progressBar->advance(count($dataChunk));
        }

        $progressBar->finish();
        $this->command->line('');

        fclose($handle);
        DB::commit();

        $this->command->info("✅ ICD9 import selesai: {$totalRows} records");
    }

    /**
     * Optimized ICD10 seeding
     */
    private function seedIcd10Optimized(): void
    {
        $file = database_path('seeders/csvs/icd10.csv');

        if (! File::exists($file)) {
            $this->command->error("File $file tidak ditemukan.");

            return;
        }

        $this->command->info('📋 Memulai import ICD10...');

        // Truncate table
        Icd10::truncate();

        $chunkSize = $this->getOptimalChunkSize();
        $dataChunk = [];
        $orderCounter = 1;
        $now = Carbon::now();

        // Hitung total baris untuk progress bar
        $totalLines = $this->countFileLines($file) - 1; // Exclude header
        $progressBar = $this->command->getOutput()->createProgressBar($totalLines);
        $progressBar->setFormat(' ICD10: %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
        $progressBar->start();

        // Start transaction
        DB::beginTransaction();

        // Baca file dengan stream
        $handle = fopen($file, 'r');
        $header = array_map('trim', str_getcsv(fgets($handle))); // Skip header

        $batchCount = 0;
        $totalRows = 0;

        while (($line = fgets($handle)) !== false) {
            $row = str_getcsv($line);

            if (count($row) < 3) {
                $progressBar->advance();

                continue;
            }

            $data = array_combine($header, $row);

            $dataChunk[] = [
                'id' => Str::uuid()->toString(),
                'code' => $data['CODE'] ?? '',
                'display' => $data['DISPLAY'] ?? '',
                'version' => $data['VERSION'] ?? '',
                'order' => $orderCounter++,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($dataChunk) >= $chunkSize) {
                $this->insertChunk('icd10s', $dataChunk, $batchCount, 'ICD10');
                $totalRows += count($dataChunk);
                $progressBar->advance(count($dataChunk));

                $dataChunk = [];
                $batchCount++;

                // Commit setiap 10 batch
                if ($batchCount % 10 === 0) {
                    DB::commit();
                    DB::beginTransaction();
                }
            }
        }

        // Insert data terakhir
        if (! empty($dataChunk)) {
            $this->insertChunk('icd10s', $dataChunk, $batchCount, 'ICD10');
            $totalRows += count($dataChunk);
            $progressBar->advance(count($dataChunk));
        }

        $progressBar->finish();
        $this->command->line('');

        fclose($handle);
        DB::commit();

        // Restore database settings
        $this->restoreDatabaseSettings();

        $this->command->info("✅ ICD10 import selesai: {$totalRows} records");
    }

    /**
     * Optimize database settings for PostgreSQL
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
                    // PostgreSQL optimizations untuk performa dan mengurangi logging
                    DB::statement('SET synchronous_commit TO OFF');
                    DB::statement('SET maintenance_work_mem TO "256MB"');
                    DB::statement('SET log_statement TO "none"'); // Disable SQL logging
                    DB::statement('SET log_min_duration_statement TO -1'); // Disable slow query logging
                    DB::statement('SET log_min_messages TO warning'); // Reduce log verbosity
                    break;

                case 'sqlite':
                    // SQLite optimizations
                    DB::statement('PRAGMA synchronous = OFF');
                    DB::statement('PRAGMA journal_mode = MEMORY');
                    DB::statement('PRAGMA cache_size = 10000');
                    break;

                default:
                    // No specific optimization for unknown drivers
                    break;
            }
        } catch (\Exception $e) {
            // Silent fallback - jangan tampilkan warning untuk mengurangi noise
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
                    // Restore PostgreSQL settings to default - silent mode
                    DB::statement('SET synchronous_commit TO ON');
                    DB::statement('RESET maintenance_work_mem');
                    DB::statement('RESET log_statement');
                    DB::statement('RESET log_min_duration_statement');
                    DB::statement('RESET log_min_messages');
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
            // Silent restore - tidak tampilkan error untuk mengurangi noise
        }
    }

    /**
     * Insert chunk dengan error handling
     */
    private function insertChunk(string $tableName, array $dataChunk, int $batchNumber, string $type): void
    {
        try {
            // Silent insert untuk menghindari verbose output
            DB::table($tableName)->insert($dataChunk);
        } catch (\Exception $e) {
            // Log error tanpa menampilkan detail SQL
            $this->command->error("❌ Error batch {$batchNumber} ({$type}): ".substr($e->getMessage(), 0, 100).'...');

            // Silent fallback - insert per row tanpa output verbose
            $successCount = 0;
            foreach ($dataChunk as $row) {
                try {
                    DB::table($tableName)->insert($row);
                    $successCount++;
                } catch (\Exception $rowError) {
                    // Skip silently untuk performa
                    continue;
                }
            }

            if ($successCount > 0) {
                $this->command->info("✅ Recovered {$successCount}/".count($dataChunk).' rows');
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

        // Estimasi: setiap row menggunakan sekitar 150 bytes (dikurangi)
        $estimatedRowSize = 150;
        $optimalSize = (int) ($availableMemory * 0.05) / $estimatedRowSize; // Gunakan 5% memory (lebih konservatif)

        // Batasi antara 100 - 5000 (lebih kecil untuk efisiensi)
        return max(100, min(5000, $optimalSize));
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

        if (! $handle) {
            return 0;
        }

        while (! feof($handle)) {
            if (fgets($handle) !== false) {
                $lines++;
            }
        }

        fclose($handle);

        return $lines;
    }
}
