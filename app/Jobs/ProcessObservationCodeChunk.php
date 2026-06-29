<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessObservationCodeChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunkFile;

    protected $chunkIndex;

    /**
     * Create a new job instance.
     */
    public function __construct($chunkFile, $chunkIndex = 0)
    {
        $this->chunkFile = $chunkFile;
        $this->chunkIndex = $chunkIndex;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Processing chunk {$this->chunkIndex}: {$this->chunkFile}");

        if (! file_exists($this->chunkFile)) {
            Log::error("Chunk file not found: {$this->chunkFile}");

            return;
        }

        $batchSize = 1000;
        $dataChunk = [];
        $totalRows = 0;

        $handle = fopen($this->chunkFile, 'r');
        $header = array_map('trim', str_getcsv(fgets($handle))); // Skip header

        while (($row = fgets($handle)) !== false) {
            $data = array_combine($header, str_getcsv($row));

            $dataChunk[] = [
                'code' => $data['LOINC_NUM'] ?? '',
                'display' => $data['LONG_COMMON_NAME'] ?? '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            if (count($dataChunk) >= $batchSize) {
                DB::table('master_observation_codes')->insert($dataChunk);
                $totalRows += count($dataChunk);
                $dataChunk = [];
            }
        }

        // Insert remaining data
        if (! empty($dataChunk)) {
            DB::table('master_observation_codes')->insert($dataChunk);
            $totalRows += count($dataChunk);
        }

        fclose($handle);

        // Clean up chunk file
        unlink($this->chunkFile);

        Log::info("Chunk {$this->chunkIndex} completed: {$totalRows} rows processed");
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Chunk processing failed for {$this->chunkFile}: ".$exception->getMessage());
    }
}
