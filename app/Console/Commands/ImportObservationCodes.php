<?php

namespace App\Console\Commands;

use App\Jobs\ProcessObservationCodeChunk;
use App\Models\Master\CodeSystem\Observation\MasterObservationCode;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use League\Csv\Reader;

class ImportObservationCodes extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'import:observation-codes
                          {file : Path to CSV file}
                          {--method=bulk : Import method (bulk|league|load-data|jobs)}
                          {--chunk-size=1000 : Number of records per chunk}
                          {--truncate : Truncate table before import}';

    /**
     * The console command description.
     */
    protected $description = 'Import observation codes from CSV file with various optimization methods';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = $this->argument('file');
        $method = $this->option('method');
        $chunkSize = (int) $this->option('chunk-size');
        $truncate = $this->option('truncate');

        // Validate file
        if (! File::exists($file)) {
            $this->error("File tidak ditemukan: {$file}");

            return 1;
        }

        $this->info('🚀 Memulai import observation codes...');
        $this->info("📁 File: {$file}");
        $this->info("⚡ Method: {$method}");
        $this->info("📦 Chunk size: {$chunkSize}");

        $startTime = microtime(true);

        // Truncate if requested
        if ($truncate) {
            $this->warn('🗑️  Truncating table...');
            MasterObservationCode::truncate();
        }

        // Execute based on method
        switch ($method) {
            case 'bulk':
                $this->bulkInsert($file, $chunkSize);
                break;
            case 'league':
                $this->leagueCSVInsert($file, $chunkSize);
                break;
            case 'load-data':
                $this->loadDataInfile($file);
                break;
            case 'jobs':
                $this->processWithJobs($file, $chunkSize);
                break;
            default:
                $this->error("Unknown method: {$method}");

                return 1;
        }

        $endTime = microtime(true);
        $executionTime = round($endTime - $startTime, 2);
        $totalRecords = MasterObservationCode::count();

        $this->info('✅ Import selesai!');
        $this->info("⏱️  Waktu eksekusi: {$executionTime} detik");
        $this->info("📊 Total records: {$totalRecords}");
        $this->info('🏃 Speed: '.round($totalRecords / $executionTime, 2).' records/detik');

        return 0;
    }

    /**
     * Bulk insert method - Recommended for most cases
     */
    private function bulkInsert($file, $chunkSize)
    {
        $this->info('📋 Menggunakan bulk insert method...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterObservationCode::unguard();

        $totalRows = 0;
        $dataChunk = [];
        $progressBar = null;

        // Get total lines for progress bar
        $totalLines = $this->countFileLines($file) - 1; // Exclude header
        $progressBar = $this->output->createProgressBar($totalLines);
        $progressBar->start();

        $handle = fopen($file, 'r');
        $header = array_map('trim', str_getcsv(fgets($handle)));

        while (($row = fgets($handle)) !== false) {
            $data = array_combine($header, str_getcsv($row));

            $dataChunk[] = [
                'code' => $data['LOINC_NUM'] ?? '',
                'display' => $data['LONG_COMMON_NAME'] ?? '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if (count($dataChunk) >= $chunkSize) {
                DB::table('master_observation_codes')->insert($dataChunk);
                $totalRows += count($dataChunk);
                $progressBar->advance(count($dataChunk));
                $dataChunk = [];
            }
        }

        // Insert remaining data
        if (! empty($dataChunk)) {
            DB::table('master_observation_codes')->insert($dataChunk);
            $totalRows += count($dataChunk);
            $progressBar->advance(count($dataChunk));
        }

        $progressBar->finish();
        $this->line('');

        fclose($handle);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterObservationCode::reguard();
    }

    /**
     * League CSV method - Good for memory efficiency
     */
    private function leagueCSVInsert($file, $chunkSize)
    {
        $this->info('📋 Menggunakan League CSV method...');

        if (! class_exists(Reader::class)) {
            $this->error('League CSV tidak terinstall. Jalankan: composer require league/csv');

            return;
        }

        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterObservationCode::unguard();

        $dataChunk = [];
        $totalRows = 0;
        $records = iterator_to_array($csv);
        $progressBar = $this->output->createProgressBar(count($records));
        $progressBar->start();

        foreach ($records as $record) {
            $dataChunk[] = [
                'code' => $record['LOINC_NUM'] ?? '',
                'display' => $record['LONG_COMMON_NAME'] ?? '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if (count($dataChunk) >= $chunkSize) {
                DB::table('master_observation_codes')->insert($dataChunk);
                $totalRows += count($dataChunk);
                $progressBar->advance(count($dataChunk));
                $dataChunk = [];
            }
        }

        // Insert remaining data
        if (! empty($dataChunk)) {
            DB::table('master_observation_codes')->insert($dataChunk);
            $totalRows += count($dataChunk);
            $progressBar->advance(count($dataChunk));
        }

        $progressBar->finish();
        $this->line('');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterObservationCode::reguard();
    }

    /**
     * LOAD DATA INFILE method - Fastest for MySQL
     */
    private function loadDataInfile($file)
    {
        $this->info('⚡ Menggunakan LOAD DATA INFILE method...');

        if (DB::getDriverName() !== 'mysql') {
            $this->error('LOAD DATA INFILE hanya support MySQL');

            return;
        }

        $tableName = (new MasterObservationCode)->getTable();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Convert relative path to absolute for MySQL
        $absolutePath = realpath($file);

        $sql = "
            LOAD DATA LOCAL INFILE '{$absolutePath}'
            INTO TABLE {$tableName}
            FIELDS TERMINATED BY ','
            OPTIONALLY ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (@col1, @col2)
            SET code = @col1,
                display = @col2,
                created_at = NOW(),
                updated_at = NOW()
        ";

        try {
            DB::statement($sql);
            $this->info('✅ LOAD DATA INFILE berhasil!');
        } catch (\Exception $e) {
            $this->error('❌ LOAD DATA INFILE gagal: '.$e->getMessage());
            $this->info('🔄 Fallback ke bulk insert...');
            $this->bulkInsert($file, 1000);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Queue jobs method - For very large files with parallel processing
     */
    private function processWithJobs($file, $chunkSize)
    {
        $this->info('🔄 Menggunakan queue jobs method...');

        // Create chunks directory
        $chunksDir = storage_path('app/chunks');
        if (! File::exists($chunksDir)) {
            File::makeDirectory($chunksDir, 0755, true);
        }

        $chunkFiles = $this->splitFileIntoChunks($file, $chunkSize);

        $this->info('📂 File dibagi menjadi '.count($chunkFiles).' chunks');

        // Dispatch jobs
        foreach ($chunkFiles as $index => $chunkFile) {
            ProcessObservationCodeChunk::dispatch($chunkFile, $index);
        }

        $this->info('🚀 '.count($chunkFiles).' jobs telah di-dispatch ke queue');
        $this->info("📊 Gunakan 'php artisan queue:work' untuk memproses jobs");
        $this->info("📈 Monitor progress dengan 'php artisan queue:monitor'");
    }

    /**
     * Split large file into smaller chunks
     */
    private function splitFileIntoChunks($file, $chunkSize)
    {
        $chunks = [];
        $handle = fopen($file, 'r');
        $header = fgets($handle);

        $chunkData = [$header];
        $lineCount = 0;
        $chunkIndex = 0;

        $progressBar = $this->output->createProgressBar($this->countFileLines($file));
        $progressBar->setMessage('Splitting file into chunks...');
        $progressBar->start();

        while (($line = fgets($handle)) !== false) {
            $chunkData[] = $line;
            $lineCount++;
            $progressBar->advance();

            if ($lineCount >= $chunkSize) {
                $chunkFile = storage_path("app/chunks/chunk_{$chunkIndex}.csv");
                file_put_contents($chunkFile, implode('', $chunkData));
                $chunks[] = $chunkFile;

                $chunkData = [$header];
                $lineCount = 0;
                $chunkIndex++;
            }
        }

        // Save remaining data
        if ($lineCount > 0) {
            $chunkFile = storage_path("app/chunks/chunk_{$chunkIndex}.csv");
            file_put_contents($chunkFile, implode('', $chunkData));
            $chunks[] = $chunkFile;
        }

        $progressBar->finish();
        $this->line('');

        fclose($handle);

        return $chunks;
    }

    /**
     * Count total lines in file
     */
    private function countFileLines($file)
    {
        $lines = 0;
        $handle = fopen($file, 'r');
        while (! feof($handle)) {
            fgets($handle);
            $lines++;
        }
        fclose($handle);

        return $lines;
    }
}
