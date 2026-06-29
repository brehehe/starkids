<?php

namespace App\Services\System\ApiOutboxTask;

use App\Models\API\ApiOutboxTask;

class ApiOutboxTaskService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Undocumented function
     *
     * @param [type] $request
     * @return void
     */
    public function createApiOutbox($request)
    {
        // dd($request);
        ApiOutboxTask::create([
            'model_classes' => isset($request['model_classes']) ? json_encode($request['model_classes']) : [],
            'model_ids' => isset($request['model_ids']) ? json_encode($request['model_ids']) : [],
            'service_class' => $request['service_class'] ?? null,
            'service_method' => $request['service_method'] ?? null,
            'request_body' => $request['request_body'] ?? null,
            'response_body' => $request['response_body'] ?? null,
            'status' => $request['status'] ?? 'pending',
            'execution' => $request['execution'] ?? 0,
        ]);
    }
}
