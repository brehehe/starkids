<?php

namespace App\Services\OneHealth\MedicationRequest;

use Exception;
use App\Traits\Encryption;
use App\Models\Company\Company;
use Illuminate\Support\Facades\Log;
use App\Traits\Company\CompanyTrait;
use Illuminate\Support\Facades\Http;
use App\Traits\OneHealth\AuthenticateTrait;
use App\Models\Encounter\OneHealth\OneHealthEncounterCode;
use App\Services\System\ApiOutboxTask\ApiOutboxTaskService;

class MedicationRequestService
{
    use AuthenticateTrait, CompanyTrait, Encryption;
    /**
     * Create a new class instance.
     */
    public $url;

    public function __construct()
    {
        //
        $this->url = config('app.one_health.url') . '/fhir-r4/v1';
    }

    public function postPutOHMedicationRequest($OHMedicationReq, $pending = false, $requestBody = [])
    {
        $OHMedicationReq->refresh();

        $one_health = $this->getOneHealth($OHMedicationReq?->OHOrganization?->company);

        $one_health_organization_id = $one_health[0];

        if (empty($requestBody)) {
            $request = [
                "resourceType" => "MedicationRequest",
                "identifier"   => $this->getIdentifier($OHMedicationReq),
                "status"       => $OHMedicationReq?->status,
                "intent"       => $OHMedicationReq?->intent,
                "category" => [
                    [
                        "coding" => [
                            [
                                "system"  => $OHMedicationReq?->OHMedicationReqCategory?->coding_system,
                                "code"    => $OHMedicationReq?->OHMedicationReqCategory?->coding_code,
                                "display" => $OHMedicationReq?->OHMedicationReqCategory?->coding_display,
                            ]
                        ]
                    ]
                ],
                "priority" => $OHMedicationReq?->priority,
                "medicationReference" => [
                    "reference" => $OHMedicationReq?->medication_reference . $OHMedicationReq?->OHMedication?->id_medication,
                    "display"   => $OHMedicationReq?->medication_display
                ],
                "subject" => [
                    "reference" => $OHMedicationReq?->subject_reference . $OHMedicationReq?->OHPatient?->id_patient,
                    "display"   => $OHMedicationReq?->subject_display,
                ],
                "encounter" => [
                    "reference" => $OHMedicationReq?->encounter_reference . $OHMedicationReq?->OHEncounter?->id_encounter
                ],
                "authoredOn" => $OHMedicationReq?->author_on,
                "requester" => [
                    "reference" => $OHMedicationReq?->OHMedicationReqRequester?->reference . $OHMedicationReq?->OHMedicationReqRequester?->reference_id,
                    "display"   => $OHMedicationReq?->OHMedicationReqRequester?->display
                ],
                "reasonCode" => [
                    [
                        // "coding" => [
                        //     [
                        //         "system"  => $OHMedicationReq?->OHMedicationReqReasonCode?->coding_system,
                        //         "code"    => $OHMedicationReq?->OHMedicationReqReasonCode?->coding_code,
                        //         "display" => $OHMedicationReq?->OHMedicationReqReasonCode?->coding_display,
                        //     ]
                        // ]
                        "coding" => $this->getConditionCode($OHMedicationReq?->OHEncounter?->encounter?->encounterConditon, $OHMedicationReq?->OHEncounter, $OHMedicationReq?->OHOrganization?->company, ['icd'])
                    ]
                ],
                "courseOfTherapyType" => [
                    "coding" => [
                        [
                            "system"  => $OHMedicationReq?->OHMedicationReqCourseTherapy?->coding_system,
                            "code"    => $OHMedicationReq?->OHMedicationReqCourseTherapy?->coding_code,
                            "display" => $OHMedicationReq?->OHMedicationReqCourseTherapy?->coding_display,
                        ]
                    ]
                ],
                "dosageInstruction" => $this->getDosageInstruction($OHMedicationReq),
                "dispenseRequest" => [
                    "dispenseInterval" => [
                        "value"  => $OHMedicationReq?->OHMedicationReqDispenseRequest?->dispense_interval_value,
                        "unit"   => $OHMedicationReq?->OHMedicationReqDispenseRequest?->dispense_interval_unit,
                        "system" => $OHMedicationReq?->OHMedicationReqDispenseRequest?->dispense_interval_system,
                        "code"   => $OHMedicationReq?->OHMedicationReqDispenseRequest?->dispense_interval_code,
                    ],
                    "validityPeriod" => [
                        "start" => $OHMedicationReq?->OHMedicationReqDispenseRequest?->validity_start,
                        "end"   => $OHMedicationReq?->OHMedicationReqDispenseRequest?->validity_end,
                    ],
                    "numberOfRepeatsAllowed" => $OHMedicationReq?->OHMedicationReqDispenseRequest?->number_repeat,
                    "quantity" => [
                        "value"  => $OHMedicationReq?->OHMedicationReqDispenseRequest?->quantity_value,
                        "unit"   => $OHMedicationReq?->OHMedicationReqDispenseRequest?->quantity_unit,
                        "system" => $OHMedicationReq?->OHMedicationReqDispenseRequest?->quantity_system,
                        "code"   => $OHMedicationReq?->OHMedicationReqDispenseRequest?->quantity_code,
                    ],
                    "expectedSupplyDuration" => [
                        "value"  => $OHMedicationReq?->OHMedicationReqDispenseRequest?->expect_value,
                        "unit"   => $OHMedicationReq?->OHMedicationReqDispenseRequest?->expect_unit,
                        "system" => $OHMedicationReq?->OHMedicationReqDispenseRequest?->expect_system,
                        "code"   => $OHMedicationReq?->OHMedicationReqDispenseRequest?->expect_code,
                    ],
                    "performer" => [
                        "reference" => $OHMedicationReq?->OHMedicationReqDispenseRequest?->performer_reference . $one_health_organization_id
                    ]
                ]
            ];
        } else {
            $request = $requestBody;
        }

        if ($OHMedicationReq?->id_medication_request) {
            $request['id'] = $OHMedicationReq?->id_medication_request;

            if ($pending == true) {
                $request_outbox = [
                    'model_classes'  => [get_class($OHMedicationReq)],
                    'model_ids'      => [$OHMedicationReq?->id],
                    'service_class'  => get_class(),
                    'service_method' => 'postPutOHMedicationRequest',
                    'request_body'   => $request ? json_encode($request) : [],
                    'status'         => 'pending',
                    'execution'      => 0,
                ];

                // dd($request);
                app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

                return [''];
            } else {
                return $this->putMedicationRequest($request, $OHMedicationReq);
            }
        } else {
            if ($pending == true) {
                $request_outbox = [
                    'model_classes'  => [get_class($OHMedicationReq)],
                    'model_ids'      => [$OHMedicationReq?->id],
                    'service_class'  => get_class(),
                    'service_method' => 'postPutOHMedicationRequest',
                    'request_body'   => $request ? json_encode($request) : [],
                    'status'         => 'pending',
                    'execution'      => 0,
                ];

                // dd($request);
                app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

                return [''];
            } else {
                return $this->postMedicationRequest($request, $OHMedicationReq);
            }
        }
    }

    private function getIdentifier($OHMedicationReq)
    {
        $identifiers = [];

        foreach ($OHMedicationReq?->OHMedicationReqIdentifiers as $key => $OHIdentifier) {
            $one_health = $this->getOneHealth($OHIdentifier?->OHOrganization?->company);

            $one_health_organization_id = $one_health[0];

            $identifiers[] = [
                "system" => $OHIdentifier?->system . $one_health_organization_id,
                "use"    => $OHIdentifier?->use,
                "value"  => $OHIdentifier?->value,
            ];
        }

        return $identifiers;
    }

    private function getDosageInstruction($OHMedicationReq)
    {
        $dosage_instructions = [];

        foreach ($OHMedicationReq?->OHMedicationReqDosageInstructions ?? [] as $key => $dosage_instruction) {
            $dosage_instructions[] = [
                "sequence"              => $dosage_instruction?->sequence,
                "text"                  => $dosage_instruction?->text,
                "additionalInstruction" => [
                    [
                        "text" => $dosage_instruction?->additional_text
                    ]
                ],
                "patientInstruction" => $dosage_instruction?->patient_instruction,
                "timing" => [
                    "repeat" => [
                        "frequency"  => $dosage_instruction?->timing_repeat_frequency,
                        "period"     => $dosage_instruction?->timing_repeat_period,
                        "periodUnit" => $dosage_instruction?->timing_repeat_period_unit,
                    ]
                ],
                "route" => [
                    "coding" => [
                        [
                            "system"  => $dosage_instruction?->route_coding_system,
                            "code"    => $dosage_instruction?->route_coding_code,
                            "display" => $dosage_instruction?->route_coding_display,
                        ]
                    ]
                ],
                "doseAndRate" => [
                    [
                        "type" => [
                            "coding" => [
                                [
                                    "system"  => $dosage_instruction?->dose_rate_type_coding_system,
                                    "code"    => $dosage_instruction?->dose_rate_type_coding_code,
                                    "display" => $dosage_instruction?->dose_rate_type_coding_display,
                                ]
                            ]
                        ],
                        "doseQuantity" => [
                            "value"  => $dosage_instruction?->dose_rate_quantity_value,
                            "unit"   => $dosage_instruction?->dose_rate_quantity_unit,
                            "system" => $dosage_instruction?->dose_rate_quantity_system,
                            "code"   => $dosage_instruction?->dose_rate_quantity_code,
                        ]
                    ]
                ]
            ];
        }

        return $dosage_instructions;
    }

    private function postMedicationRequest($request, $OHMedicationReq)
    {
        $company = Company::find($OHMedicationReq?->OHOrganization?->company?->id);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->post($this->url . '/MedicationRequest', $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHMedicationReq?->OHOrganization?->company);
            $company = Company::find($OHMedicationReq?->OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->post($this->url . '/MedicationRequest', $request);
        }

        $responseBody = $response->json();
        if (!$response->successful()) {
            $message      = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        $OHMedicationReq->updateQuietly([
            'id_medication_request' => $responseBody['id'] ?? null
        ]);

        if (config('app.name') != 'production') Log::info('Successfully OneHealth_MedicationRequestService->postMedicationRequest', $responseBody);

        return $responseBody;
    }

    private function putMedicationRequest($request, $OHMedicationReq)
    {
        $company = Company::find($OHMedicationReq?->OHOrganization?->company?->id);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->put($this->url . '/MedicationRequest/' . $OHMedicationReq?->id_medication_request, $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHMedicationReq?->OHOrganization?->company);
            $company = Company::find($OHMedicationReq?->OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->put($this->url . '/MedicationRequest/' . $OHMedicationReq?->id_medication_request, $request);
        }

        $responseBody = $response->json();
        if (!$response->successful()) {
            $message      = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        if (config('app.name') != 'production') Log::info('Successfully OneHealth_MedicationRequestService->putMedicationRequest', $responseBody);

        return $responseBody;
    }

    private function getConditionCode($encounterCondition, $OHEncounter, $company, $types)
    {
        $details = [];
        $oneHealthEncounterCodes = OneHealthEncounterCode::where('one_health_encounter_id', $OHEncounter->id)
            ->where('encounter_condition_id', $encounterCondition->id)
            ->where('company_id', $company->id)
            ->whereIn('type', $types)
            ->get();

        foreach ($oneHealthEncounterCodes as $oneHealthEncounterCode) {
            $details[] = [
                "system" => $oneHealthEncounterCode?->system ?? "http://snomed.info/sct",
                "code" => $oneHealthEncounterCode?->code ?? "274640006",
                "display" => $oneHealthEncounterCode?->display ?? "Fever with chills"
            ];
        }

        return $details;
    }
}
