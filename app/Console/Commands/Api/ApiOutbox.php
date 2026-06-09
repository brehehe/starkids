<?php

namespace App\Console\Commands\Api;

use Exception;
use Throwable;
use Illuminate\Console\Command;
use App\Models\Api\ApiOutboxTask;
use Illuminate\Support\Facades\DB;
use App\Services\System\ApiOutboxTask\ApiOutboxTaskService;
use Illuminate\Support\Facades\Log;

class ApiOutbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:api-outbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Executionn Of Pending API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $responseBody = null;
        $models = [];
        $api_outbox     = ApiOutboxTask::where('status', 'pending')->where('execution', '<=', 3)->orderBy('order', 'ASC')->first();
        $service_class  = $api_outbox?->service_class;
        $service_method = $api_outbox?->service_method;
        $request        = json_decode($api_outbox?->request_body, true);

        try {
            foreach (json_decode($api_outbox?->model_classes, true) ?? [] as $key => $value) {
                $models[] = json_decode($api_outbox?->model_classes, true)[$key]::find(json_decode($api_outbox?->model_ids, true)[$key]);
            }

            if (!$api_outbox) return;

            DB::beginTransaction();
                $api_outbox->update([
                    'status' => 'process'
                ]);

                $params = array_merge($models, [false, $request]);
                $responseBody = app($service_class)->$service_method(...$params);

                $api_outbox->update([
                    'status'        => 'success',
                    'response_body' => json_encode($responseBody)
                ]);
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();

            $errors = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error('Ada kesalahan saat execute API logbox', $errors);

            $api_outbox->update([
                'status'        => 'failed',
                'response_body' => $responseBody ? json_decode($responseBody, true) : json_encode($errors, true)
            ]);

            $request = [
                'model_classes'  => json_decode($api_outbox->model_classes, true),
                'model_ids'      => json_decode($api_outbox->model_ids, true),
                'service_class'  => $api_outbox->service_class,
                'service_method' => $api_outbox->service_method,
                'request_body'   => $api_outbox->request_body,
                'status'         => 'pending',
                'execution'      => (int)$api_outbox->execution + 1,
            ];

            if ((int)$api_outbox->execution <= 3) {
                app(ApiOutboxTaskService::class)->createApiOutbox($request);
            }
        }
    }
}
