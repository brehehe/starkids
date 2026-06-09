<?php

namespace App\Services\OneHealth\Patient;

use App\Models\Company\Company;
use App\Models\Company\OneHealth\OneHealthOrganization;
use App\Models\Patient\OneHealth\OneHealthPatient;
use App\Services\System\ApiOutboxTask\ApiOutboxTaskService;
use App\Traits\Company\CompanyTrait;
use App\Traits\Encryption;
use App\Traits\OneHealth\AuthenticateTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PatientService
{
    /**
     * Create a new class instance.
     */

    use CompanyTrait, AuthenticateTrait, Encryption;

    public $url;

    public function __construct()
    {
        //
        $this->url = config('app.one_health.url'). '/fhir-r4/v1';
    }

    public function postPutPatient($OHPatient, $OHOrganization, $pending = false, $requestBody = [])
    {
        $OHPatient->refresh();
        $OHOrganization->refresh();

        if ($OHPatient?->id_patient) {
            return $this->patchPatient($OHPatient, $OHOrganization, $pending, $requestBody);
        } else {
            return $this->postPatient($OHPatient, $OHOrganization, $pending , $requestBody);
        }
    }

    //POST
    private function postPatient($OHPatient, $OHOrganization, $pending = false, $requestBody = [])
    {
        if (empty($requestBody)) {
            $request = [
                "resourceType" => "Patient",
                "meta"         => [
                    "profile" => [$OHPatient?->meta_profile]
                ],
                "identifier" => $this->getIdentifier($OHPatient),
                "active"     => $OHPatient?->active,
                "name"       => [
                    [
                        "use" => $OHPatient?->name_use,
                        "text" => $OHPatient?->name_text,
                    ]
                ],
                "gender"          => $OHPatient?->gender,
                "birthDate"       => $OHPatient?->birth_date?->format('Y-m-d'),
                "deceasedBoolean" => $OHPatient?->deceased_boolean,
                "address" => [
                    [
                        "use" => $OHPatient?->OHPatientAddress?->use,
                        "line" => [
                            $OHPatient?->OHPatientAddress?->line,
                        ],
                        "city"       => $OHPatient?->OHPatientAddress?->city,
                        "postalCode" => $OHPatient?->OHPatientAddress?->postal_code,
                        "country"    => $OHPatient?->OHPatientAddress?->country,
                        "extension" => [
                            [
                                "url"       => $OHPatient?->OHPatientAddress?->extention_url,
                                "extension" => $this->getAddressExtension($OHPatient?->OHPatientAddress)
                            ]
                        ]
                    ]
                ],
                "maritalStatus" => [
                    "coding" => [
                        [
                            "system"  => $OHPatient?->marital_status_coding_system,
                            "code"    => $OHPatient?->marital_status_coding_code,
                            "display" => $OHPatient?->marital_status_coding_display,
                        ]
                    ],
                    "text" => $OHPatient?->marital_status_coding_display
                ],
                "multipleBirthInteger" => 0,
                "communication" => [
                    [
                        "language" => [
                            "coding" => [
                                [
                                    "system"  => "urn:ietf:bcp:47",
                                    "code"    => "id-ID",
                                    "display" => "Indonesian"
                                ]
                            ],
                            "text" => "Indonesian"
                        ],
                        "preferred" => true
                    ]
                ]
            ];
        } else {
            $request = $requestBody;
        }

        if ($pending == true) {
            $request_outbox = [
                'model_classes'  => [get_class($OHPatient), get_class($OHOrganization)],
                'model_ids'      => [$OHPatient?->id, $OHOrganization?->id],
                'service_class'  => get_class(),
                'service_method' => 'postPutPatient',
                'request_body'   => $request ? json_encode($request) : [],
                'status'         => 'pending',
                'execution'      => 0,
            ];

            app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

            return [''];
        }

        // going to API
        $company  = Company::find($OHOrganization?->company?->id);
        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->post($this->url .'/Patient', $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHOrganization?->company);
            $company = Company::find($OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->post($this->url .'/Patient', $request);
        }

        $responseBody = $response->json();
        if (!$response->successful()) {
            $message      = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        $OHPatient->updateQuietly([
            'id_patient' => $responseBody['id'] ?? null
        ]);

        if (config('app.name') != 'production') Log::info('Successfully PatientService->postPatient', $responseBody);

        return $responseBody;
    }

    private function getIdentifier($OHPatient)
    {
        $identifiers = [];
        //set identifier
        // dd($OHPatient->OHPatientIdentifiers[1]);
        foreach ($OHPatient->OHPatientIdentifiers ?? [] as $key => $identifier) {
            $identifiers [] = [
                "use"    => $identifier?->use,
                "system" => $identifier?->system,
                "value"  => $identifier?->system == "https://fhir.kemkes.go.id/id/ihs-number" ? $identifier?->value : $this->decrypted($identifier?->value),
            ];
        }

        return $identifiers;
    }

    private function getAddressExtension($OHPatientAddress)
    {
        $extentions = [];

        foreach ($OHPatientAddress?->extensions ?? [] as $key => $extention) {
            $extentions[] = [
                "url"       => $extention?->url,
                "valueCode" => $extention?->value_code,
            ];
        }

        return $extentions;
    }

    private function getContactTelecom($OHPatientContactRelationship)
    {
        $telecoms = [];

        foreach ($OHPatientContactRelationship?->contactTelecoms ?? [] as $key => $telecom) {
            $telecoms[] = [
                "system" => $telecom?->system,
                "value"  => $telecom?->value,
                "use"    => $telecom?->use,
            ];
        }

        return $telecoms;
    }

    //PUT
    private function patchPatient($OHPatient, $OHOrganization, $pending = false, $requestBody = [])
    {
        if (empty($requestBody)) {
            $request = [
                [
                    "op" => "test",
                    "path" => "/name",
                    "value" => [
                        [
                            "use" => $OHPatient?->name_use,
                            "text" => $OHPatient?->name_text,
                        ]
                    ]
                ],
                [
                    "op" => "replace",
                    "path" => "/name",
                    "value" => [
                        [
                            "use" => $OHPatient?->name_use,
                            "text" => $OHPatient?->name_text,
                        ]
                    ]
                ],
                [
                    "op"    => "test",
                    "path"  => "/gender",
                    "value" => $OHPatient?->gender
                ],
                [
                    "op"    => "replace",
                    "path"  => "/gender",
                    "value" => $OHPatient?->gender
                ],
                [
                    "op"    => "test",
                    "path"  => "/birthDate",
                    "value" => $OHPatient?->birth_date?->format('Y-m-d')
                ],
                [
                    "op"    => "replace",
                    "path"  => "/birthDate",
                    "value" => $OHPatient?->birth_date?->format('Y-m-d')
                ],
                [
                    "op"    => "replace",
                    "path"  => "/identifier",
                    "value" => $this->getIdentifier($OHPatient)
                ],
                [
                    "op"    => "replace",
                    "path"  => "/maritalStatus",
                    "value" => [
                        "coding" => [
                            [
                                "system"  => $OHPatient?->marital_status_coding_system,
                                "code"    => $OHPatient?->marital_status_coding_code,
                                "display" => $OHPatient?->marital_status_coding_display,
                            ]
                        ],
                        "text" => $OHPatient?->marital_status_coding_display
                    ]
                ],
                [
                    "op"    => "replace",
                    "path"  => "/address",
                    "value" => [
                        [
                            "use" => $OHPatient?->OHPatientAddress?->use,
                            "line" => [
                                $OHPatient?->OHPatientAddress?->line,
                            ],
                            "city"       => $OHPatient?->OHPatientAddress?->city,
                            "postalCode" => $OHPatient?->OHPatientAddress?->postal_code,
                            "country"    => $OHPatient?->OHPatientAddress?->country,
                            "extension" => [
                                [
                                    "url"       => $OHPatient?->OHPatientAddress?->extention_url,
                                    "extension" => $this->getAddressExtension($OHPatient?->OHPatientAddress)
                                ]
                            ]
                        ]
                    ]
                ],
            ];

            $identifier_nik = collect($this->getIdentifier($OHPatient))->where('system', 'https://fhir.kemkes.go.id/id/nik')->first();
            if (!$identifier_nik) {
                unset($request[6]);
            }

        } else {
            $request = $requestBody;
        }

        if ($pending == true) {
            $request_outbox = [
                'model_classes'  => [get_class($OHPatient), get_class($OHOrganization)],
                'model_ids'      => [$OHPatient?->id, $OHOrganization?->id],
                'service_class'  => get_class(),
                'service_method' => 'postPutPatient',
                'request_body'   => $request ? json_encode($request) : [],
                'status'         => 'pending',
                'execution'      => 0,
            ];

            app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

            return [''];
        }

        // going to API
        $company  = Company::find($OHOrganization?->company?->id);
        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->patch($this->url .'/Patient/'. $OHPatient?->id_patient, $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHOrganization?->company);
            $company = Company::find($OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->post($this->url .'/Patient/'. $OHPatient?->id_patient, $request);
        }

        $responseBody = $response->json();
        if (!$response->successful()) {
            $message      = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        $OHPatient->updateQuietly([
            'id_patient' => $responseBody['id'] ?? null
        ]);

        if (config('app.name') != 'production') Log::info('Successfully PatientService->patchPatient', $responseBody);

        return $responseBody;
    }

    //GET
    public function getPatient($request, $company)
    {
        // going to API
        $company  = Company::find($company?->id);

        $param = [
            'identifier' => 'https://fhir.kemkes.go.id/id/nik|'. $request['nik']
        ];

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->get($this->url .'/Patient', $param);

        if ($response->unauthorized()) {
            $this->accessToken($company);
            $company = Company::find($company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->get($this->url .'/Patient', $param);
        }

        $responseBody = $response->json();
        if (!$response->successful()) {
            $message      = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        if (config('app.name') != 'production') Log::info('Successfully PatientService->getPatient', $responseBody);

        $response = [
            'success' => true,
            'message' => 'Successfully OneHealthPatientService->getPatient',
            'data'    => $responseBody
        ];

        return $response;
    }

    // {"file": "/Applications/DATA EWA/Mediction/mediction/app/Services/OneHealth/Patient/PatientService.php", "line": 148, "message": "{\"resourceType\":\"OperationOutcome\",\"text\":{\"status\":\"generated\"},\"issue\":[{\"severity\":\"error\",\"code\":\"exception\",\"details\":{\"text\":\"Patient with nik-ibu is not female\"}}]}"}
}
