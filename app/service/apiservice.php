<?php

namespace App\service;

use App\Models\Patient\Patient;
use App\Models\User;
use App\Traits\Company\CompanyTrait;
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
        $appHost = parse_url(config('app.url'), PHP_URL_HOST) ?? '';
        $host = parse_url($url, PHP_URL_HOST) ?? '';

        $isInternal = str_contains($url, '/api/testing/')
            || in_array(config('app.env'), ['local', 'development', 'testing'])
            || in_array($host, ['localhost', '127.0.0.1', $appHost])
            || empty($host);

        if ($isInternal) {
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

    public function getPratition($request): mixed
    {
        return null;
    }

    /**
     * Dipakai oleh halaman SatuSehat — createUser / queuePatient.
     */
    public function createUser(User $user, bool $identity_card_mother = false): array
    {
        $userDetail = $user->userDetail;

        $gender = $userDetail?->administrative_gender;
        $birthDate = $userDetail?->birth_date;
        $deceasedDate = $userDetail?->deceased_date;
        $identityCard = $userDetail?->identity_card;
        $passportNumber = $userDetail?->passport_number;
        $familyCardNumber = $userDetail?->family_card_number;
        $maritalStatus = $userDetail?->marital_status;
        $provinceCode = $userDetail?->province_code;
        $cityCode = $userDetail?->city_code;
        $districtCode = $userDetail?->district_code;
        $subDistrictCode = $userDetail?->sub_district_code;
        $address = $userDetail?->address;
        $postalCode = $userDetail?->postal_code;
        $rt = $userDetail?->rt;
        $rw = $userDetail?->rw;

        if (config('app.env') === 'local' || config('app.env') === 'testing') {
            $gender = $gender ?: 'male';
            $maritalStatus = $maritalStatus ?: 'U';
            $provinceCode = $provinceCode ?: '35';
            $cityCode = $cityCode ?: '3578';
            $districtCode = $districtCode ?: '357801';
            $subDistrictCode = $subDistrictCode ?: '3578011001';
            $address = $address ?: 'Jl. Raya Mediction';
            $postalCode = $postalCode ?: '60111';
            $rt = $rt ?: '001';
            $rw = $rw ?: '001';
        }

        // Langkah 1: Cek apakah sudah ada pasien berdasarkan company_id, nik, dan name
        $checkResponse = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get($this->url.'/testing/patient/get-nik', [
            'company_id' => $user->company_id,
            'nik' => $identityCard,
            'name' => $user->name,
            'user_id' => $user->id,
            'gender' => $gender,
            'birth_date' => $birthDate ? $birthDate->format('Y-m-d') : null,
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
            'gender' => $gender ?? 'male',
            'birth_date' => $birthDate ? $birthDate->format('Y-m-d') : null,
            'deceased_date' => $deceasedDate ? $deceasedDate->format('Y-m-d') : null,
            'identity_card' => $identityCard,
            'passport_number' => $passportNumber,
            'family_card_number' => $familyCardNumber,
            'marital_status' => $maritalStatus ?? 'U',
            'identity_card_mother' => $identity_card_mother,
            'status' => 'active',
            'patient_detail' => [
                'province' => [
                    'code' => $provinceCode,
                ],
                'city' => [
                    'code' => $cityCode,
                ],
                'district' => [
                    'code' => $districtCode,
                ],
                'sub_district' => [
                    'code' => $subDistrictCode,
                ],
                'address' => $address,
                'postal_code' => $postalCode,
                'country' => 'ID',
                'rt' => $rt,
                'rw' => $rw,
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

        if (! $response->successful()) {
            $msg = $responseData['message'] ?? 'Gagal menambahkan pasien ke antrian';
            if (! empty($responseData['errors'])) {
                $details = [];
                foreach ($responseData['errors'] as $field => $errs) {
                    $details[] = implode(', ', $errs);
                }
                $msg .= ' ('.implode('; ', $details).')';
            }
            throw new \Exception($msg);
        }

        return $responseData;
    }

    public function syncCompany($company): mixed
    {
        return null;
    }

    public function syncLocation($location): mixed
    {
        return null;
    }

    /**
     * Dipakai oleh halaman SatuSehat — queueEncounter.
     */
    public function createTransaction($data): mixed
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post($this->url.'/testing/encounter/post-put', $data);

        $responseData = $response->json();
        Log::info('API Response Encounter: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        if (! $response->successful()) {
            $msg = $responseData['message'] ?? 'Gagal menambahkan kunjungan ke antrian';
            if (! empty($responseData['errors'])) {
                $details = [];
                foreach ($responseData['errors'] as $field => $errs) {
                    $details[] = implode(', ', $errs);
                }
                $msg .= ' ('.implode('; ', $details).')';
            }
            throw new \Exception($msg);
        }

        return $responseData;
    }

    public function createConditionPrimary($data): mixed
    {
        return null;
    }

    public function createMedictation($data): mixed
    {
        return null;
    }

    public function createMedicationRequest($data): mixed
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post($this->url.'/testing/medication-request/post-put', $data);

        $responseData = $response->json();
        Log::info('API Response MedicationRequest: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }

    public function createMedicationDispense($data): mixed
    {
        return null;
    }

    public function createCompany($company): array
    {
        return [];
    }

    public function createCondition($data): mixed
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post($this->url.'/testing/condition/postput', $data);

        $responseData = $response->json();
        Log::info('API Response Condition: ', [
            'response_data' => $responseData,
            'status_code' => $response->status(),
            'success' => $response->successful(),
        ]);

        return $responseData;
    }
}
