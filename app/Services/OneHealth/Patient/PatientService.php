<?php

namespace App\Services\OneHealth\Patient;

use App\Models\Company\Company;
use App\Services\System\ApiOutboxTask\ApiOutboxTaskService;
use App\Traits\Company\CompanyTrait;
use App\Traits\Encryption;
use App\Traits\OneHealth\AuthenticateTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PatientService
{
    /**
     * Create a new class instance.
     */
    use AuthenticateTrait, CompanyTrait, Encryption;

    public $url;

    public function __construct()
    {
        //
        $this->url = config('app.one_health.url').'/fhir-r4/v1';
    }

    public function postPutPatient($OHPatient, $OHOrganization, $pending = false, $requestBody = [])
    {
        $OHPatient->refresh();
        $OHOrganization->refresh();

        Log::info('[PatientService] postPutPatient routing', [
            'has_id_patient' => ! empty($OHPatient?->id_patient),
            'id_patient' => $OHPatient?->id_patient,
            'pending' => $pending,
        ]);

        if ($OHPatient?->id_patient) {
            return $this->patchPatient($OHPatient, $OHOrganization, $pending, $requestBody);
        } else {
            return $this->postPatient($OHPatient, $OHOrganization, $pending, $requestBody);
        }
    }

    // POST
    private function postPatient($OHPatient, $OHOrganization, $pending = false, $requestBody = [])
    {
        if (empty($requestBody)) {
            $request = [
                'resourceType' => 'Patient',
                'meta' => [
                    'profile' => [$OHPatient?->meta_profile],
                ],
                'identifier' => $this->getIdentifier($OHPatient),
                'active' => $OHPatient?->active,
                'name' => [
                    [
                        'use' => $OHPatient?->name_use,
                        'text' => ucwords(strtolower(trim($OHPatient?->name_text ?? ''))),
                    ],
                ],
                'gender' => $OHPatient?->gender,
                'birthDate' => $OHPatient?->getRawOriginal('birth_date'),
                'deceasedBoolean' => $OHPatient?->deceased_boolean,
                'address' => [
                    [
                        'use' => $OHPatient?->OHPatientAddress?->use,
                        'line' => [
                            $OHPatient?->OHPatientAddress?->line,
                        ],
                        'city' => $OHPatient?->OHPatientAddress?->city,
                        'postalCode' => $OHPatient?->OHPatientAddress?->postal_code,
                        'country' => $OHPatient?->OHPatientAddress?->country,
                        'extension' => [
                            [
                                'url' => $OHPatient?->OHPatientAddress?->extention_url,
                                'extension' => $this->getAddressExtension($OHPatient?->OHPatientAddress),
                            ],
                        ],
                    ],
                ],
                'maritalStatus' => [
                    'coding' => [
                        [
                            'system' => $OHPatient?->marital_status_coding_system,
                            'code' => $OHPatient?->marital_status_coding_code,
                            'display' => $OHPatient?->marital_status_coding_display,
                        ],
                    ],
                    'text' => $OHPatient?->marital_status_coding_display,
                ],
                'multipleBirthInteger' => 0,
                'communication' => [
                    [
                        'language' => [
                            'coding' => [
                                [
                                    'system' => 'urn:ietf:bcp:47',
                                    'code' => 'id-ID',
                                    'display' => 'Indonesian',
                                ],
                            ],
                            'text' => 'Indonesian',
                        ],
                        'preferred' => true,
                    ],
                ],
            ];
        } else {
            $request = $requestBody;
        }

        if ($pending == true) {
            $request_outbox = [
                'model_classes' => [get_class($OHPatient), get_class($OHOrganization)],
                'model_ids' => [$OHPatient?->id, $OHOrganization?->id],
                'service_class' => get_class(),
                'service_method' => 'postPutPatient',
                'request_body' => $request ? json_encode($request) : [],
                'status' => 'pending',
                'execution' => 0,
            ];

            app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

            return [''];
        }

        // going to API
        $company = Company::find($OHOrganization?->company?->id);

        // 1. GET check: step-by-step fallback chain before attempting POST
        $existingPatient = $this->searchPatientInSatuSehat($request, $OHPatient, $OHOrganization, $company);
        // Reload company after potential token refresh inside searchPatientInSatuSehat
        $company = Company::find($OHOrganization?->company?->id);

        Log::info('[PatientService] searchPatientInSatuSehat result', [
            'found' => ! is_null($existingPatient),
            'satusehat_id' => $existingPatient['id'] ?? null,
        ]);

        if ($existingPatient && isset($existingPatient['id'])) {
            $OHPatient->updateQuietly([
                'id_patient' => $existingPatient['id'],
            ]);

            Log::info('Patient already exists in SatuSehat, skipped POST and updated ID', $existingPatient);

            return $existingPatient;
        }

        // 2. CREATE: POST to register if not found
        Log::info('[PatientService] POST /Patient request payload', [
            'name' => $request['name'] ?? null,
            'birthDate' => $request['birthDate'] ?? null,
            'gender' => $request['gender'] ?? null,
            'identifier' => $request['identifier'] ?? null,
        ]);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->post($this->url.'/Patient', $request);

        Log::info('[PatientService] POST /Patient response status', [
            'status' => $response->status(),
            'successful' => $response->successful(),
        ]);

        if ($response->unauthorized()) {
            $this->accessToken($OHOrganization?->company);
            $company = Company::find($OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->post($this->url.'/Patient', $request);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        $OHPatient->updateQuietly([
            'id_patient' => $responseBody['id'] ?? null,
        ]);

        if (config('app.name') != 'production') {
            Log::info('Successfully PatientService->postPatient', $responseBody);
        }

        return $responseBody;
    }

    /**
     * Step-by-step fallback search chain for a patient in SatuSehat.
     *
     * Steps (returns first match found):
     *  1. GET by NIK IBU + birthdate       (newborn/bayi)
     *  2. GET by NIK                        (regular patient)
     *  3. GET by Name + NIK                 (combined search)
     *  4. GET by Name + Birthdate + Gender  (last fallback when no NIK)
     *
     * @param  array<string, mixed>  $request
     * @param  mixed  $OHPatient
     * @param  mixed  $OHOrganization
     * @param  mixed  $company
     * @return array<string, mixed>|null
     */
    private function searchPatientInSatuSehat(array $request, $OHPatient, $OHOrganization, &$company): ?array
    {
        $nik = null;
        $isNewborn = (bool) ($OHPatient->patient?->identity_card_mother ?? false);
        $birthDate = $request['birthDate'] ?? null;
        $gender = $request['gender'] ?? null;
        $nameText = null;

        foreach ($request['identifier'] ?? [] as $identifier) {
            if ($identifier['system'] === 'https://fhir.kemkes.go.id/id/nik') {
                $nik = $identifier['value'];
            } elseif ($identifier['system'] === 'https://fhir.kemkes.go.id/id/nik-ibu') {
                $nik = $identifier['value'];
                $isNewborn = true;
            }
        }

        foreach ($request['name'] ?? [] as $nameObj) {
            $nameText = $nameObj['text'] ?? $nameText;
        }

        $steps = [];

        // Step 1: GET by NIK IBU + birthdate (for newborns)
        if ($isNewborn && $nik && $birthDate) {
            $steps[] = [
                'label' => 'NIK IBU + birthdate',
                'params' => [
                    'identifier' => 'https://fhir.kemkes.go.id/id/nik-ibu|'.$nik,
                    'birthdate' => $birthDate,
                ],
            ];
        }

        // Step 2: GET by NIK (regular patient)
        if ($nik && ! $isNewborn) {
            $steps[] = [
                'label' => 'NIK',
                'params' => [
                    'identifier' => 'https://fhir.kemkes.go.id/id/nik|'.$nik,
                ],
            ];
        }

        // Step 3: GET by Name + NIK (combined)
        if ($nameText && $nik && ! $isNewborn) {
            $steps[] = [
                'label' => 'Name + NIK',
                'params' => [
                    'name' => $nameText,
                    'identifier' => 'https://fhir.kemkes.go.id/id/nik|'.$nik,
                ],
            ];
        }

        // Step 4: GET by Name + Birthdate + Gender (last fallback)
        if ($nameText && $birthDate && $gender) {
            $steps[] = [
                'label' => 'Name + Birthdate + Gender',
                'params' => [
                    'name' => $nameText,
                    'birthdate' => $birthDate,
                    'gender' => $gender,
                ],
            ];
        }

        foreach ($steps as $step) {
            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->get($this->url.'/Patient', $step['params']);

            if ($response->unauthorized()) {
                $this->accessToken($OHOrganization?->company);
                $company = Company::find($OHOrganization?->company?->id);

                $response = Http::withToken($company?->one_health_access_token ?? '')
                    ->withOptions(['verify' => false])
                    ->get($this->url.'/Patient', $step['params']);
            }

            if ($response->successful()) {
                $body = $response->json();
                $found = $body['entry'][0]['resource'] ?? null;

                if ($found && isset($found['id'])) {
                    Log::info('Patient found at SatuSehat via step: '.$step['label'], ['satusehat_id' => $found['id']]);

                    return $found;
                }
            }
        }

        return null;
    }

    private function getIdentifier($OHPatient): array
    {
        $identifiers = [];
        // set identifier
        // dd($OHPatient->OHPatientIdentifiers[1]);
        foreach ($OHPatient->OHPatientIdentifiers ?? [] as $key => $identifier) {
            $identifiers[] = [
                'use' => $identifier?->use,
                'system' => $identifier?->system,
                'value' => $identifier?->system == 'https://fhir.kemkes.go.id/id/ihs-number' ? $identifier?->value : $this->decrypted($identifier?->value),
            ];
        }

        return $identifiers;
    }

    private function getAddressExtension($OHPatientAddress)
    {
        $extentions = [];

        foreach ($OHPatientAddress?->extensions ?? [] as $key => $extention) {
            $extentions[] = [
                'url' => $extention?->url,
                'valueCode' => $extention?->value_code,
            ];
        }

        return $extentions;
    }

    private function getContactTelecom($OHPatientContactRelationship)
    {
        $telecoms = [];

        foreach ($OHPatientContactRelationship?->contactTelecoms ?? [] as $key => $telecom) {
            $telecoms[] = [
                'system' => $telecom?->system,
                'value' => $telecom?->value,
                'use' => $telecom?->use,
            ];
        }

        return $telecoms;
    }

    // PUT
    private function patchPatient($OHPatient, $OHOrganization, $pending = false, $requestBody = [])
    {
        if (empty($requestBody)) {
            $request = [
                [
                    'op' => 'test',
                    'path' => '/name',
                    'value' => [
                        [
                            'use' => $OHPatient?->name_use,
                            'text' => ucwords(strtolower(trim($OHPatient?->name_text ?? ''))),
                        ],
                    ],
                ],
                [
                    'op' => 'replace',
                    'path' => '/name',
                    'value' => [
                        [
                            'use' => $OHPatient?->name_use,
                            'text' => ucwords(strtolower(trim($OHPatient?->name_text ?? ''))),
                        ],
                    ],
                ],
                [
                    'op' => 'test',
                    'path' => '/gender',
                    'value' => $OHPatient?->gender,
                ],
                [
                    'op' => 'replace',
                    'path' => '/gender',
                    'value' => $OHPatient?->gender,
                ],
                [
                    'op' => 'test',
                    'path' => '/birthDate',
                    'value' => $OHPatient?->getRawOriginal('birth_date'),
                ],
                [
                    'op' => 'replace',
                    'path' => '/birthDate',
                    'value' => $OHPatient?->getRawOriginal('birth_date'),
                ],
                [
                    'op' => 'replace',
                    'path' => '/identifier',
                    'value' => $this->getIdentifier($OHPatient),
                ],
                [
                    'op' => 'replace',
                    'path' => '/maritalStatus',
                    'value' => [
                        'coding' => [
                            [
                                'system' => $OHPatient?->marital_status_coding_system,
                                'code' => $OHPatient?->marital_status_coding_code,
                                'display' => $OHPatient?->marital_status_coding_display,
                            ],
                        ],
                        'text' => $OHPatient?->marital_status_coding_display,
                    ],
                ],
                [
                    'op' => 'replace',
                    'path' => '/address',
                    'value' => [
                        [
                            'use' => $OHPatient?->OHPatientAddress?->use,
                            'line' => [
                                $OHPatient?->OHPatientAddress?->line,
                            ],
                            'city' => $OHPatient?->OHPatientAddress?->city,
                            'postalCode' => $OHPatient?->OHPatientAddress?->postal_code,
                            'country' => $OHPatient?->OHPatientAddress?->country,
                            'extension' => [
                                [
                                    'url' => $OHPatient?->OHPatientAddress?->extention_url,
                                    'extension' => $this->getAddressExtension($OHPatient?->OHPatientAddress),
                                ],
                            ],
                        ],
                    ],
                ],
            ];

            $identifier_nik = collect($this->getIdentifier($OHPatient))->where('system', 'https://fhir.kemkes.go.id/id/nik')->first();
            if (! $identifier_nik) {
                unset($request[6]);
            }
        } else {
            $request = $requestBody;
        }

        if ($pending == true) {
            $request_outbox = [
                'model_classes' => [get_class($OHPatient), get_class($OHOrganization)],
                'model_ids' => [$OHPatient?->id, $OHOrganization?->id],
                'service_class' => get_class(),
                'service_method' => 'postPutPatient',
                'request_body' => $request ? json_encode($request) : [],
                'status' => 'pending',
                'execution' => 0,
            ];

            app(ApiOutboxTaskService::class)->createApiOutbox($request_outbox);

            return [''];
        }

        // going to API
        $company = Company::find($OHOrganization?->company?->id);

        Log::info('[PatientService] patchPatient PATCH payload', [
            'id_patient' => $OHPatient?->id_patient,
            'name_text' => $OHPatient?->name_text,
            'birth_date' => $OHPatient?->birth_date?->format('Y-m-d'),
            'request_preview' => array_map(fn ($r) => ['op' => $r['op'] ?? null, 'path' => $r['path'] ?? null], is_array($request) ? array_values($request) : []),
        ]);

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->patch($this->url.'/Patient/'.$OHPatient?->id_patient, $request);

        if ($response->unauthorized()) {
            $this->accessToken($OHOrganization?->company);
            $company = Company::find($OHOrganization?->company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->post($this->url.'/Patient/'.$OHPatient?->id_patient, $request);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        $OHPatient->updateQuietly([
            'id_patient' => $responseBody['id'] ?? null,
        ]);

        if (config('app.name') != 'production') {
            Log::info('Successfully PatientService->patchPatient', $responseBody);
        }

        return $responseBody;
    }

    // GET
    public function getPatient(array $request, Company $company): array
    {
        // going to API
        $company = Company::find($company->id);

        $responseBody = null;
        $idPatient = $request['id_patient'] ?? $request['id'] ?? null;
        $nik = $request['nik'] ?? null;
        $name = $request['name'] ?? null;
        $gender = $request['gender'] ?? null;
        $birthDate = $request['birth_date'] ?? $request['birthdate'] ?? null;

        // 1. Cari berdasarkan ID SatuSehat
        if ($idPatient) {
            try {
                $response = Http::withToken($company->one_health_access_token ?? '')
                    ->withOptions(['verify' => false])
                    ->get($this->url.'/Patient/'.$idPatient);

                if ($response->unauthorized()) {
                    $this->accessToken($company);
                    $company = Company::find($company->id);

                    $response = Http::withToken($company->one_health_access_token ?? '')
                        ->withOptions(['verify' => false])
                        ->get($this->url.'/Patient/'.$idPatient);
                }

                if ($response->successful()) {
                    $responseBody = [
                        'resourceType' => 'Bundle',
                        'entry' => [
                            [
                                'resource' => $response->json(),
                            ],
                        ],
                    ];
                }
            } catch (\Throwable $th) {
                Log::warning('Failed search patient by ID fallback to NIK: '.$th->getMessage());
            }
        }

        // 2. Cari berdasarkan NIK jika belum ditemukan
        if ((! $responseBody || (isset($responseBody['entry']) && empty($responseBody['entry']))) && $nik) {
            $isNewborn = ! empty($request['identity_card_mother']);
            $identifierSystem = $isNewborn ? 'https://fhir.kemkes.go.id/id/nik-ibu|' : 'https://fhir.kemkes.go.id/id/nik|';

            $param = [
                'identifier' => $identifierSystem.$nik,
            ];
            $responseBody = $this->queryPatientApi($param, $company);
        }

        // 3. Cari berdasarkan Nama + Tanggal Lahir + Gender jika belum ditemukan
        if ((! $responseBody || (isset($responseBody['entry']) && empty($responseBody['entry']))) && $name && $birthDate && $gender) {
            $formattedBirthDate = Carbon::parse($birthDate)->format('Y-m-d');
            $param = [
                'name' => $name,
                'birthdate' => $formattedBirthDate,
                'gender' => $gender,
            ];
            $responseBody = $this->queryPatientApi($param, $company);
        }

        if (! $responseBody || (isset($responseBody['entry']) && empty($responseBody['entry']))) {
            return [
                'success' => false,
                'message' => 'Pasien tidak ditemukan di Satu Sehat',
                'data' => [],
            ];
        }

        return [
            'success' => true,
            'message' => 'Successfully OneHealthPatientService->getPatient',
            'data' => $responseBody,
        ];
    }

    private function queryPatientApi(array $param, Company $company): ?array
    {
        $response = Http::withToken($company->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->get($this->url.'/Patient', $param);

        if ($response->unauthorized()) {
            $this->accessToken($company);
            $company = Company::find($company->id);

            $response = Http::withToken($company->one_health_access_token ?? '')
                ->withOptions(['verify' => false])
                ->get($this->url.'/Patient', $param);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        if (config('app.name') != 'production') {
            Log::info('Successfully PatientService->queryPatientApi', $responseBody);
        }

        return $responseBody;
    }

    // {"file": "/Applications/DATA EWA/Mediction/mediction/app/Services/OneHealth/Patient/PatientService.php", "line": 148, "message": "{\"resourceType\":\"OperationOutcome\",\"text\":{\"status\":\"generated\"},\"issue\":[{\"severity\":\"error\",\"code\":\"exception\",\"details\":{\"text\":\"Patient with nik-ibu is not female\"}}]}"}
}
