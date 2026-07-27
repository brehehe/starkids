<?php

namespace App\Services\OneHealth\Encounter;

use App\Models\Company\Company;
use App\Models\Encounter\OneHealth\OneHealthEncounter;
use App\Services\System\ApiOutboxTask\ApiOutboxTaskService;
use App\Traits\Company\CompanyTrait;
use App\Traits\OneHealth\AuthenticateTrait;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EncounterService
{
    /**
     * Create a new class instance.
     */
    use AuthenticateTrait, CompanyTrait;

    public $url;

    public function __construct()
    {
        //
        $this->url = config('app.one_health.url').'/fhir-r4/v1';
    }

    public function postPutEncounter($OHEncounter, $pending = false, $requestBody = [])
    {
        $OHEncounter = OneHealthEncounter::find($OHEncounter?->id);

        $one_health = $this->getOneHealth($OHEncounter?->encounter?->company);

        $one_health_organization_id = $one_health[0];

        if (empty($requestBody)) {
            $diagnosis = $this->getDiagnosis($OHEncounter);
            $status = $OHEncounter?->status;

            if ($status === 'finished' && empty($diagnosis)) {
                $status = 'in-progress';
            }

            $request = [
                'resourceType' => 'Encounter',
                'status' => $status,
                'class' => [
                    'system' => $OHEncounter?->class_system,
                    'code' => $OHEncounter?->class_code,
                    'display' => $OHEncounter?->class_display,
                ],
                'subject' => [
                    'reference' => $OHEncounter?->subject_reference.$OHEncounter?->OHPatient?->id_patient,
                    'display' => $OHEncounter?->OHPatient?->name_text,
                ],
                'participant' => $this->getParticipant($OHEncounter),
                'period' => [
                    'start' => $OHEncounter?->period_start,
                    'end' => $OHEncounter?->period_end,
                ],
                'location' => $this->getLocation($OHEncounter),
                'statusHistory' => $this->getStatusHistory($OHEncounter?->encounter, $status),
                'serviceProvider' => [
                    'reference' => $OHEncounter?->service_provider_reference.$one_health_organization_id,
                ],
                'identifier' => [
                    [
                        'system' => $OHEncounter?->OHEncounterIdentifier?->system.$one_health_organization_id,
                        'value' => $OHEncounter?->OHEncounterIdentifier?->value,
                    ],
                ],
                'hospitalization' => [
                    'dischargeDisposition' => [
                        'coding' => [
                            [
                                'system' => $OHEncounter?->OHEncounterHospitalDischarge?->coding_system,
                                'code' => $OHEncounter?->OHEncounterHospitalDischarge?->coding_code,
                                'display' => $OHEncounter?->OHEncounterHospitalDischarge?->coding_display,
                            ],
                        ],
                        'text' => $OHEncounter?->OHEncounterHospitalDischarge?->text,
                    ],
                ],
                'diagnosis' => $diagnosis,
            ];

            if (! $OHEncounter?->period_end) {
                unset($request['period']['end']);
            }

            if (! $OHEncounter?->encounter?->hospital_discharge_text) {
                unset($request['hospitalization']);
            }

            if (empty($request['diagnosis'])) {
                unset($request['diagnosis']);
            }
        } else {
            $request = $requestBody;
            if (isset($request['status']) && $request['status'] === 'finished' && (empty($request['diagnosis']) || ! isset($request['diagnosis']))) {
                $request['status'] = 'in-progress';
            }
            if (isset($request['diagnosis']) && empty($request['diagnosis'])) {
                unset($request['diagnosis']);
            }
        }

        Log::info('EncounterService->buildRequestBody', $request);

        if ($OHEncounter?->id_encounter) {
            $request['id'] = $OHEncounter?->id_encounter;

            if ($pending == true) {
                $request_outbox = [
                    'model_classes' => [get_class($OHEncounter)],
                    'model_ids' => [$OHEncounter?->id],
                    'service_class' => get_class(),
                    'service_method' => 'postPutEncounter',
                    'request_body' => $request ? json_encode($request) : [],
                    'status' => 'pending',
                    'execution' => 0,
                ];

                Log::info('EncounterService->postPutEncounter', $request);

                // dd($request);
                app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

                return [''];
            } else {
                return $this->putEncounter($OHEncounter, $request);
            }
        } else {

            if ($pending == true) {
                $request_outbox = [
                    'model_classes' => [get_class($OHEncounter)],
                    'model_ids' => [$OHEncounter?->id],
                    'service_class' => get_class(),
                    'service_method' => 'postPutEncounter',
                    'request_body' => $request ? json_encode($request) : [],
                    'status' => 'pending',
                    'execution' => 0,
                ];

                // dd($request);
                app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

                return [''];
            } else {
                return $this->postEncounter($OHEncounter, $request);
            }
        }
    }

    private function postEncounter($OHEncounter, $request)
    {
        $company = Company::find($OHEncounter?->encounter?->company?->id);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->post($this->url.'/Encounter', $request);

        if ($response->unauthorized()) {

            $this->accessToken($OHEncounter?->encounter?->company);
            $company = Company::find($OHEncounter?->encounter?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->post($this->url.'/Encounter', $request);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        // edit id_encounter with response API
        $OHEncounter->updateQuietly([
            'id_encounter' => isset($responseBody['id']) ? $responseBody['id'] : null,
        ]);

        if (config('app.name') != 'production') {
            Log::info('Successfully OneHealth_EncounterService->postEncounter', $responseBody);
        }

        return $responseBody;
    }

    private function putEncounter($OHEncounter, $request)
    {
        $company = Company::find($OHEncounter?->encounter?->company?->id);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->put($this->url.'/Encounter/'.$OHEncounter?->id_encounter, $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHEncounter?->encounter?->company);
            $company = Company::find($OHEncounter?->encounter?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->put($this->url.'/Encounter/'.$OHEncounter?->id_encounter, $request);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        if (config('app.name') != 'production') {
            Log::info('Successfully OneHealth_EncounterService->putEncounter', $responseBody);
        }

        return $responseBody;
    }

    private function getLocation($OHEncounter)
    {
        $locations = [];

        foreach ($OHEncounter?->OHEncounterLocations ?? [] as $key => $location) {
            $locations[] = [
                'location' => [
                    'reference' => $location?->location_reference.$location?->OHLocation?->id_location,
                    'display' => $location?->location_display,
                ],
            ];
        }

        return $locations;
    }

    private function getStatusHistory($encounter, ?string $overrideLatestStatus = null)
    {
        $status_histories = [];
        $histories = $encounter->statusHistories ?? [];
        $count = count($histories);

        foreach ($histories as $key => $status) {
            $statusCode = $status?->status;
            if ($overrideLatestStatus && $key === $count - 1 && $statusCode === 'finished') {
                $statusCode = $overrideLatestStatus;
            }
            $status_histories[] = [
                'status' => $statusCode,
                'period' => [
                    'start' => $status?->period_start,
                    'end' => $status?->period_end,
                ],
            ];
        }

        return $status_histories;
    }

    private function getParticipant($OHEncounter)
    {
        $participants = [];

        foreach ($OHEncounter?->OHEncounterParticipants ?? [] as $key => $participant) {
            $participants[] = [
                'type' => [
                    [
                        'coding' => [
                            [
                                'system' => $participant?->type_coding_system,
                                'code' => $participant?->type_coding_code,
                                'display' => $participant?->type_coding_display,
                            ],
                        ],
                    ],
                ],
                'individual' => [
                    'reference' => $participant?->individual_reference.$participant?->OHPractitioner?->id_practitiont,
                    'display' => $participant?->individual_display,
                ],
            ];
        }

        return $participants;
    }

    private function getDiagnosis($OHEncounter)
    {
        $diagnosis = [];

        foreach ($OHEncounter?->OHConditions ?? [] as $key => $OHCondition) {
            if (! empty($OHCondition?->id_condition)) {
                $diagnosis[] = [
                    'condition' => [
                        'reference' => 'Condition/'.$OHCondition->id_condition,
                    ],
                    'rank' => count($diagnosis) + 1,
                ];
            }
        }

        return $diagnosis;
    }
}
