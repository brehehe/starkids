<?php

namespace Tests\Feature;

use App\Models\Company\Company;
use App\Models\Company\OneHealthy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class OneHealthPatientSearchTest extends TestCase
{
    use RefreshDatabase;

    protected $company;

    protected $oneHealthy;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create a Company manually (avoiding the broken factory)
        $this->company = Company::create([
            'id' => (string) Str::uuid(),
            'code' => 'TESTCOMP',
            'name' => 'Test Medical Center',
            'email' => 'test@starkids.com',
            'phone' => '081234567890',
            'website' => 'starkids.com',
            'is_active' => true,
        ]);

        // 2. Create OneHealthy configuration for Company
        $this->oneHealthy = OneHealthy::create([
            'company_id' => $this->company->id,
            'organization_id' => 'org-123',
            'client_id' => 'client-123',
            'client_secret' => 'secret-123',
        ]);
    }

    /**
     * Test search by NIK (when identity_card_mother is false/empty)
     */
    public function test_search_by_nik(): void
    {
        Http::fake([
            '*/oauth2/v1/accesstoken*' => Http::response([
                'access_token' => 'mock-access-token-123',
            ], 200),
            '*/fhir-r4/v1/Patient?identifier=https%3A%2F%2Ffhir.kemkes.go.id%2Fid%2Fnik%7C3515155012910001' => Http::response([
                'resourceType' => 'Bundle',
                'entry' => [
                    [
                        'resource' => [
                            'resourceType' => 'Patient',
                            'id' => 'satusehat-id-nik',
                            'active' => true,
                            'name' => [
                                ['text' => 'Budi Santoso'],
                            ],
                            'gender' => 'male',
                            'birthDate' => '1991-12-15',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/testing/patient/get-nik?'.http_build_query([
            'company_id' => $this->company->id,
            'nik' => '3515155012910001',
            'name' => 'Budi Santoso',
        ]));

        $response->assertStatus(200);
        $response->assertJsonPath('data.resource.id', 'satusehat-id-nik');
    }

    /**
     * Test search by NIK Ibu (when identity_card_mother is true)
     */
    public function test_search_by_nik_ibu(): void
    {
        Http::fake([
            '*/oauth2/v1/accesstoken*' => Http::response([
                'access_token' => 'mock-access-token-123',
            ], 200),
            '*/fhir-r4/v1/Patient?identifier=https%3A%2F%2Ffhir.kemkes.go.id%2Fid%2Fnik-ibu%7C3515155012910001' => Http::response([
                'resourceType' => 'Bundle',
                'entry' => [
                    [
                        'resource' => [
                            'resourceType' => 'Patient',
                            'id' => 'satusehat-id-nik-ibu',
                            'active' => true,
                            'name' => [
                                ['text' => 'Bayi Ny. Budi'],
                            ],
                            'gender' => 'female',
                            'birthDate' => '2026-05-15',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/testing/patient/get-nik?'.http_build_query([
            'company_id' => $this->company->id,
            'nik' => '3515155012910001',
            'name' => 'Bayi Ny. Budi',
            'identity_card_mother' => 1,
        ]));

        $response->assertStatus(200);
        $response->assertJsonPath('data.resource.id', 'satusehat-id-nik-ibu');
    }

    /**
     * Test search by Name + Birth Date + Gender (when NIK is empty)
     */
    public function test_search_by_name_birthdate_gender(): void
    {
        Http::fake([
            '*/oauth2/v1/accesstoken*' => Http::response([
                'access_token' => 'mock-access-token-123',
            ], 200),
            '*/fhir-r4/v1/Patient?name=Budi&birthdate=1991-12-15&gender=male' => Http::response([
                'resourceType' => 'Bundle',
                'entry' => [
                    [
                        'resource' => [
                            'resourceType' => 'Patient',
                            'id' => 'satusehat-id-fallback',
                            'active' => true,
                            'name' => [
                                ['text' => 'Budi'],
                            ],
                            'gender' => 'male',
                            'birthDate' => '1991-12-15',
                            'identifier' => [
                                [
                                    'system' => 'https://fhir.kemkes.go.id/id/nik',
                                    'value' => '3515155012919999',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/testing/patient/get-nik?'.http_build_query([
            'company_id' => $this->company->id,
            'name' => 'Budi',
            'birth_date' => '1991-12-15',
            'gender' => 'male',
        ]));

        $response->assertStatus(200);
        $response->assertJsonPath('data.resource.id', 'satusehat-id-fallback');
    }
}
