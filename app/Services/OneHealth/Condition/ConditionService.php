<?php

namespace App\Services\OneHealth\Condition;

use App\Models\Company\Company;
use App\Services\System\ApiOutboxTask\ApiOutboxTaskService;
use App\Traits\Company\CompanyTrait;
use App\Traits\OneHealth\AuthenticateTrait;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConditionService
{
    use AuthenticateTrait, CompanyTrait;

    /**
     * Create a new class instance.
     */
    public $url;

    public function __construct()
    {
        //
        $this->url = config('app.one_health.url').'/fhir-r4/v1';
    }

    public function postPutCondition($OHCondition, $pending = false, $requestBody = [])
    {
        $OHCondition->refresh();

        $code_codings = [];
        foreach ($OHCondition->OHConditionCodes ?? [] as $key => $OHConditionCode) {
            $code_codings[] = [
                'system' => $OHConditionCode->coding_system,
                'code' => $OHConditionCode->coding_code,
                'display' => $OHConditionCode->coding_display,
            ];
        }

        if (empty($requestBody)) {
            $request = [
                'resourceType' => 'Condition',
                'clinicalStatus' => [
                    'coding' => [
                        [
                            'system' => $OHCondition->OHConditionClinicalStatus->coding_system,
                            'code' => $OHCondition->OHConditionClinicalStatus->coding_code,
                            'display' => $OHCondition->OHConditionClinicalStatus->coding_display,
                        ],
                    ],
                ],
                'category' => [
                    [
                        'coding' => [
                            [
                                'system' => $OHCondition->OHConditionCategory->coding_system,
                                'code' => $OHCondition->OHConditionCategory->coding_code,
                                'display' => $OHCondition->OHConditionCategory->coding_display,
                            ],
                        ],
                    ],
                ],
                'code' => [
                    'coding' => $code_codings,
                ],
                'subject' => [
                    'reference' => $OHCondition?->subject_reference.$OHCondition?->OHPatient?->id_patient,
                    'display' => $OHCondition?->subject_display,
                ],
                'encounter' => [
                    'reference' => $OHCondition?->encounter_reference.$OHCondition?->OHEncounter?->id_encounter,
                ],
            ];
        } else {
            $request = $requestBody;
        }

        if ($OHCondition?->id_condition) {
            $request['id'] = $OHCondition?->id_condition;

            if ($pending == true) {
                $request_outbox = [
                    'model_classes' => [get_class($OHCondition)],
                    'model_ids' => [$OHCondition?->id],
                    'service_class' => get_class(),
                    'service_method' => 'postPutCondition',
                    'request_body' => $request ? json_encode($request) : [],
                    'status' => 'pending',
                    'execution' => 0,
                ];

                // dd($request);
                app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

                return [''];
            } else {
                return $this->putCondition($OHCondition, $request);
            }
        } else {
            if ($pending == true) {
                $request_outbox = [
                    'model_classes' => [get_class($OHCondition)],
                    'model_ids' => [$OHCondition?->id],
                    'service_class' => get_class(),
                    'service_method' => 'postPutCondition',
                    'request_body' => $request ? json_encode($request) : [],
                    'status' => 'pending',
                    'execution' => 0,
                ];

                // dd($request);
                app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

                return [''];
            } else {
                return $this->postCondition($OHCondition, $request);
            }
        }
    }

    private function postCondition($OHCondition, $request)
    {
        $company = Company::find($OHCondition?->OHOrganization?->company?->id);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->post($this->url.'/Condition', $request);

        if ($response->unauthorized()) {

            $this->accessToken($OHCondition?->OHOrganization?->company);
            $company = Company::find($OHCondition?->OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->post($this->url.'/Condition', $request);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        $OHCondition->updateQuietly([
            'id_condition' => isset($responseBody['id']) ? $responseBody['id'] : null,
        ]);

        if (config('app.name') != 'production') {
            Log::info('Successfully OneHealth_ConditionService->postCondition', $responseBody);
        }

        return $responseBody;
    }

    private function putCondition($OHCondition, $request)
    {
        $company = Company::find($OHCondition?->OHOrganization?->company?->id);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->put($this->url.'/Condition/'.$OHCondition?->id_condition, $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHCondition?->OHOrganization?->company);
            $company = Company::find($OHCondition?->OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->put($this->url.'/Condition/'.$OHCondition?->id_condition, $request);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        if (config('app.name') != 'production') {
            Log::info('Successfully OneHealth_ConditionService->putCondition', $responseBody);
        }

        return $responseBody;
    }
}
