<?php

namespace App\Console\Commands\Api;

use App\Models\Api\ApiOutboxTask;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ApiOutboxDaemon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:api-outbox-daemon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daemon to process pending SatuSehat outbox tasks every 1 second';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('SatuSehat Api Outbox Daemon running... (Ctrl+C to quit)');

        while (true) {
            $task = ApiOutboxTask::where('status', 'pending')
                ->where('execution', '<=', 3)
                ->orderBy('order', 'ASC')
                ->first();

            if ($task) {
                $this->info(sprintf('[%s] Processing task %s (%s)', now()->toDateTimeString(), $task->id, $task->service_method));
                Artisan::call('app:api-outbox');
            }

            sleep(1);
        }
    }
}
