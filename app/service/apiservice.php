<?php

namespace App\service;

use App\Models\Patient\Patient;
use App\Models\User;
use App\Traits\Company\CompanyTrait;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class apiservice
{
    use CompanyTrait;

    protected $url;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // $this->url = 'https://mediction.test/api';
        $this->url = config('app.url').'/api';
    }

    protected function withHeaders(array $headers)
    {
        return new class($this)
        {
            protected $apiservice;

            public function __construct($apiservice)
            {
                $this->apiservice = $apiservice;
            }

            public function get($url, $data = [])
            {
                return $this->apiservice->handleHttpRequest('GET', $url, $data);
            }

            public function post($url, $data = [])
            {
                return $this->apiservice->handleHttpRequest('POST', $url, $data);
            }
        };
    }

    public function handleHttpRequest(string $method, string $url, array $data = [])
    {
        if (config('app.env') === 'local' || config('app.env') === 'testing') {
            $parsedUrl = parse_url($url);
            $path = $parsedUrl['path'] ?? '';

            $requestData = [];
            $content = null;
            if (strtoupper($method) === 'GET') {
                $requestData = $data;
            } else {
                $content = json_encode($data);
            }

            $request = Request::create($path, $method, $requestData, [], [], [], $content);
            $request->headers->set('Accept', 'application/json');
            $request->headers->set('Content-Type', 'application/json');

            $response = app()->handle($request);

            return new class($response)
            {
                protected $response;

                public function __construct($response)
                {
                    $this->response = $response;
                }

                public function json($key = null)
                {
                    $decoded = json_decode($this->response->getContent(), true);
                    if ($key) {
                        return $decoded[$key] ?? null;
                    }

                    return $decoded;
                }

                public function ok()
                {
                    return $this->response->isSuccessful();
                }

                public function successful()
                {
                    return $this->response->isSuccessful();
                }

                public function status()
                {
                    return $this->response->getStatusCode();
                }
            };
        }

        if (strtoupper($method) === 'GET') {
            return Http::withHeaders(['Accept' => 'application/json'])->get($url, $data);
        } else {
            return Http::withHeaders(['Accept' => 'application/json'])->post($url, $data);
        }
    }

    public function getPratition($request)
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->get($this->url.'/testing/practitiont/get-by-nik', $request);

        return $response->json();
    }

    public function createUser(User $user, bool $identity_card_mother = false): array
    {
        // Langkah 1: Cek apakah sudah ada pasien berdasarkan company_id, nik, dan name
        $checkResponse = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get($this->url.'/testing/patient/get-nik', [
            'company_id' => $user->company_id,
            'nik' => $user->userDetail->identity_card,
            'name' => $user->name,
            'user_id' => $user->id,
            'gender' => $user->userDetail->administrative_gender,
            'birth_date' => $user->userDetail->birth_date ? $user->userDetail->birth_date->format('Y-m-d') : null,
            'identity_card_mother' => $identity_card_mother ? 1 : 0,
        ]);

        // Jika pasien sudah ditemukan di Satu Sehat, hentikan proses
        if ($checkResponse->ok() && $checkResponse->json('data')) {
            $checkResponseData = $checkResponse->json();
            Log::info('Pasien sudah terdaftar di Satu Sehat.', [
                'response_data' => $checkResponseData,
                'status_code' => $checkResponse->status(),
                'success' => $checkResponse->successful(),
            ]);

            return [
                'message' => 'Pasien sudah terdaftar di Satu Sehat.',
                'status' => 'exists',
                'data' => $checkResponseData['data'] ?? null,
            ];
        }

        // Jika belum ada, lanjut membuat pasien
        $patient = Patient::where('user_id', $user->id)->select('id')->first();

        $data = [
            'pending' => true,
            'id' => $patient->id ?? null,
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'name' => $user->name,
            'email' => $user->email,
            'gender' => $user->userDetail->administrative_gender,
            'birth_date' => $user->userDetail->birth_date,
            'deceased_date' => $user->userDetail->deceased_date,
            'identity_card' => $user->userDetail->identity_card,
            'passport_number' => $user?->userDetail?->passport_number,
            'family_card_number' => $user?->userDetail?->family_card_number,
            'marital_status' => $user->userDetail->marital_status,
            'identity_card_mother' => $identity_card_mother,
            'status' => 'active',
            'patient_detail' => [
                'province' => [
                    'code' => $user->userDetail->province_code,
                ],
                'city' => [
                    'code' => $user->userDetail->city_code,
                ],
                'district' => [
                    'code' => $user->userDetail->district_code,
                ],
                'sub_district' => [
                    'code' => $user->userDetail->sub_district_code,
                ],
                'address' => $user->userDetail->address,
                'postal_code' => $user->userDetail->postal_code,
                'country' => 'ID',
                'rt' => $user->userDetail->rt,
                'rw' => $user->userDetail->rw,
                'longitude' => 0,
                'latitude' => 0,
                'altitude' => 0,
            ],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post($this->url.'/testing/patient/post-put', $data);

        $responseData = $response->json();
        Log::info('API Response Patient: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function syncCompany($company)
    {
        $data = [
            'pending' => true,
            'id' => $company->id,
            'company_id' => $company->company_id,
            'code' => $company->code,
            'name' => $company->name,
            'email' => $company->email,
            'phone' => $company->phone,
            'website' => $company->website,
            'is_active' => $company->is_active ?? true,
            'pic' => [
                'name' => $company->pic_name,
                'position' => $company->pic_position,
                'email' => $company->pic_email,
                'phone' => $company->pic_phone,
            ],
            'company_detail' => [
                'province' => [
                    'code' => $company->companyDetail->province_code,
                ],
                'city' => [
                    'code' => $company->companyDetail->city_code,
                ],
                'district' => [
                    'code' => $company->companyDetail->district_code,
                ],
                'sub_district' => [
                    'code' => $company->companyDetail->sub_district_code,
                ],
                'address' => $company->companyDetail->address,
                'postal_code' => $company->companyDetail->postal_code,
                'country' => $company->companyDetail->country,
                'rt' => $company->companyDetail->rt,
                'rw' => $company->companyDetail->rw,
                'longitude' => $company->companyDetail->longitude,
                'latitude' => $company->companyDetail->latitude,
                'altitude' => $company->companyDetail->altitude,
            ],
            'one_health' => [
                'organization_id' => Crypt::decryptString($company->oneHealthy->organization_id),
                'client_id' => Crypt::decryptString($company->oneHealthy->client_id),
                'client_secret' => Crypt::decryptString($company->oneHealthy->client_secret),
            ],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/company/post-put', $data);

        $responseData = $response->json();
        Log::info('API Response: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function syncLocation($location)
    {
        $data = [
            // "pending" => true,
            'id' => $location->id,
            'company_id' => $location->company_id,
            'location_id' => null,
            'status' => $location->status,
            'name' => $location->name,
            'description' => $location->description,
            'mode' => $location->mode,
            'physical_type' => $location->physical_type,
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/location/post-put', $data);

        $responseData = $response->json();
        Log::info('API Response: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function createTransaction($data)
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/encounter/post-put', $data);
        $responseData = $response->json();
        Log::info('API Response Encounter: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function createConditionPrimary($data)
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/condition/post-put', $data);
        $responseData = $response->json();
        Log::info('API Response Condition Primary: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function createMedictation($data)
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/medication/post-put', $data);
        $responseData = $response->json();
        Log::info('API Response Medication: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function createMedicationRequest($data)
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/medication-request/post-put', $data);
        $responseData = $response->json();
        Log::info('API Response Medication Request: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function createMedicationDispense($data)
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/medication-dispense/post-put', $data);
        $responseData = $response->json();
        Log::info('API Response Medication Dispense: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function createCompany($company): array
    {

        $data = [
            'pending' => true,
            'id' => '0197db07-894c-70be-89ae-72ed7cbb1feb',
            'company_id' => $company->id,
            'code' => '1Br0ck',
            'name' => 'Burningroom Mediction',
            'email' => 'burningroommediction@gmail.com',
            'phone' => '08961280948',
            'website' => 'https://burningroom.co.id',
            'is_active' => true,
            'pic' => [
                'name' => 'Eleven',
                'position' => 'CEO',
                'email' => 'eleven@gmail.com',
                'phone' => '0812321312',
            ],
            'company_detail' => [
                'province' => [
                    'code' => 35,
                ],
                'city' => [
                    'code' => 3578,
                ],
                'district' => [
                    'code' => 357803,
                ],
                'sub_district' => [
                    'code' => 3578031006,
                ],
                'address' => 'jl. raya utama medokan raya',
                'postal_code' => 34345,
                'country' => 'ID',
                'rt' => '1',
                'rw' => '8',
                'longitude' => 8.123,
                'latitude' => -0.177,
                'altitude' => 3.77,
            ],
            'one_health' => [
                'organization_id' => '3e1a2508-04ef-43da-ac34-ff7a8ad6bc88',
                'client_id' => 'gAMGybjyc0atZ2R6gpRBYspiWv5aExDcKGqlV6uSalUPswLN',
                'client_secret' => '5z2rqwLmSv7XdttW45Et6Vk8ez5NyHexLXMSAtInKz2NfhtcGSKhIVWPbKVXoca2',
            ],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/company/post-put', $data);
        $responseData = $response->json();
        Log::info('API Response Company: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function createCondition($data)
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->url.'/testing/condition/postput', $data);
        $responseData = $response->json();
        Log::info('API Response Condition: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }
}
