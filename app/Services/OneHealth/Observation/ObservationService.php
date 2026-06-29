<?php

namespace App\Services\OneHealth\Observation;

use App\Models\Company\Company;
use App\Services\System\ApiOutboxTask\ApiOutboxTaskService;
use App\Traits\Company\CompanyTrait;
use App\Traits\Encryption;
use App\Traits\OneHealth\AuthenticateTrait;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ObservationService
{
    use AuthenticateTrait, CompanyTrait, Encryption;

    /**
     * Create a new class instance.
     */
    public $url;

    public function __construct()
    {
        //
        $this->url = config('app.one_health.url').'/fhir-r4/v1';
    }

    public function postPutObservation($OHObservation, $pending = false, $requestBody = [])
    {
        $OHObservation->refresh();

        if (empty($requestBody)) {
            $request = [
                'resourceType' => 'Observation',
                'status' => $OHObservation?->status,
                'category' => [
                    [
                        'coding' => [
                            [
                                'system' => $OHObservation?->OHObservationCategory?->coding_system,
                                'code' => $OHObservation?->OHObservationCategory?->coding_code,
                                'display' => $OHObservation?->OHObservationCategory?->coding_display,
                            ],
                        ],
                    ],
                ],
                'code' => [
                    'coding' => [
                        [
                            'system' => $OHObservation?->OHObservationCode?->coding_system,
                            'code' => $OHObservation?->OHObservationCode?->coding_code,
                            'display' => $OHObservation?->OHObservationCode?->coding_display,
                        ],
                    ],
                ],
                'subject' => [
                    'reference' => $OHObservation?->subject_reference.$OHObservation?->OHPatient?->id_patient,
                ],
                'performer' => [
                    [
                        'reference' => $OHObservation?->performer_reference.$OHObservation?->OHPractitioner?->id_practitiont,
                    ],
                ],
                'encounter' => [
                    'reference' => $OHObservation?->encounter_reference.$OHObservation?->OHEncounter?->id_encounter,
                ],
                'effectiveDateTime' => $OHObservation?->effective_date_time,
                'issued' => $OHObservation?->issued,
                'valueQuantity' => [
                    'system' => $OHObservation?->OHObservationValueQuantity?->system,
                    'value' => $OHObservation?->OHObservationValueQuantity?->value,
                    'code' => $OHObservation?->OHObservationValueQuantity?->code,
                    'unit' => $OHObservation?->OHObservationValueQuantity?->unit,
                ],
            ];
        } else {
            $request = $requestBody;
        }

        if ($OHObservation?->id_observation) {
            $request['id'] = $OHObservation?->id_observation;

            if ($pending == true) {
                $request_outbox = [
                    'model_classes' => [get_class($OHObservation)],
                    'model_ids' => [$OHObservation?->id],
                    'service_class' => get_class(),
                    'service_method' => 'postPutObservation',
                    'request_body' => $request ? json_encode($request) : [],
                    'status' => 'pending',
                    'execution' => 0,
                ];

                // dd($request);
                app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

                return [''];
            } else {
                return $this->putObservation($request, $OHObservation);
            }
        } else {

            if ($pending == true) {
                $request_outbox = [
                    'model_classes' => [get_class($OHObservation)],
                    'model_ids' => [$OHObservation?->id],
                    'service_class' => get_class(),
                    'service_method' => 'postPutObservation',
                    'request_body' => $request ? json_encode($request) : [],
                    'status' => 'pending',
                    'execution' => 0,
                ];

                // dd($request);
                app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

                return [''];
            } else {
                return $this->postObservation($request, $OHObservation);
            }
        }
    }

    private function postObservation($request, $OHObservation)
    {
        $company = Company::find($OHObservation?->OHOrganization?->company?->id);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->post($this->url.'/Observation', $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHObservation?->OHOrganization?->company);
            $company = Company::find($OHObservation?->OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->post($this->url.'/Observation', $request);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        $OHObservation->updateQuietly([
            'id_observation' => $responseBody['id'] ?? null,
        ]);

        if (config('app.name') != 'production') {
            Log::info('Successfully OneHealth_ObservationService->postObservation', $responseBody);
        }

        return $responseBody;
    }

    private function putObservation($request, $OHObservation)
    {
        $company = Company::find($OHObservation?->OHOrganization?->company?->id);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->put($this->url.'/Observation/'.$OHObservation?->id_medication_request, $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHObservation?->OHOrganization?->company);
            $company = Company::find($OHObservation?->OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->put($this->url.'/Observation/'.$OHObservation?->id_medication_request, $request);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        if (config('app.name') != 'production') {
            Log::info('Successfully OneHealth_ObservationService->putObservation', $responseBody);
        }

        return $responseBody;
    }
}
