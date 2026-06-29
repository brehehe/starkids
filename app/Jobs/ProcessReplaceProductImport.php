<?php

namespace App\Jobs;

use App\Imports\ReplaceProductImport;
use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ProcessReplaceProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The maximum number of seconds the job can run.
     *
     * @var int
     */
    public $timeout = 300; // 5 minutes

    /**
     * @var string
     */
    public $filePath;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var string
     */
    public $progressKey;

    /**
     * Create a new job instance.
     */
    public function __construct(string $filePath, int $userId, string $progressKey)
    {
        $this->filePath = $filePath;
        $this->userId = $userId;
        $this->progressKey = $progressKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Update progress to processing
            $this->updateProgress([
                'status' => 'processing',
                'message' => 'Memproses file Excel...',
                'progress' => 10,
            ]);

            // Authenticate the user for the import
            $user = User::find($this->userId);
            if (! $user) {
                throw new Exception('User tidak ditemukan');
            }

            auth()->login($user);

            // Check if file exists
            if (! Storage::exists($this->filePath)) {
                throw new Exception('File tidak ditemukan');
            }

            $this->updateProgress([
                'status' => 'processing',
                'message' => 'Membaca file Excel...',
                'progress' => 20,
            ]);

            // Create import instance
            $import = new ReplaceProductImport;

            // Process the Excel file
            Excel::import($import, $this->filePath);

            // Get results
            $results = $import->getResults();

            $this->updateProgress([
                'status' => 'processing',
                'message' => 'Menyelesaikan import...',
                'progress' => 90,
            ]);

            // Clean up the file
            if (Storage::exists($this->filePath)) {
                Storage::delete($this->filePath);
            }

            // Update final progress
            $finalProgress = [
                'status' => 'completed',
                'message' => 'Import berhasil diselesaikan',
                'progress' => 100,
                'results' => $results,
                'completed_at' => now()->toISOString(),
            ];

            $this->updateProgress($finalProgress);

            // Log successful import
            Log::info('Replace product import completed successfully', [
                'user_id' => $this->userId,
                'results' => $results,
                'progress_key' => $this->progressKey,
            ]);
        } catch (Exception $e) {
            $this->handleFailure($e);
        }
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $this->handleFailure($exception);
    }

    /**
     * Handle failure and update progress
     *
     * @return void
     */
    private function handleFailure(Throwable $exception)
    {
        // Clean up the file if it exists
        if (Storage::exists($this->filePath)) {
            Storage::delete($this->filePath);
        }

        // Update progress with error
        $this->updateProgress([
            'status' => 'failed',
            'message' => 'Import gagal: '.$exception->getMessage(),
            'progress' => 0,
            'error' => $exception->getMessage(),
            'failed_at' => now()->toISOString(),
        ]);

        // Log the error
        Log::error('Replace product import failed', [
            'user_id' => $this->userId,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'progress_key' => $this->progressKey,
            'file_path' => $this->filePath,
        ]);
    }

    /**
     * Update job progress in cache
     *
     * @return void
     */
    private function updateProgress(array $data)
    {
        $data['updated_at'] = now()->toISOString();
        Cache::put($this->progressKey, $data, now()->addHours(2));
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['replace-product-import', 'user:'.$this->userId];
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array
     */
    public function backoff()
    {
        return [30, 60, 120]; // 30 seconds, 1 minute, 2 minutes
    }
}
