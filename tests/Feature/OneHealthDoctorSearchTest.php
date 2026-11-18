<?php

namespace Tests\Feature;

use App\Livewire\Admin\Master\Doctor\AdminMasterDoctorIndex;
use App\Models\Company\Company;
use App\Models\Company\OneHealthy;
use App\Models\Role\RoleCompany;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserDetail;
use App\service\apiservice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class OneHealthDoctorSearchTest extends TestCase
{
    use RefreshDatabase;

    protected $company;

    protected $oneHealthy;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->company = Company::create([
            'id' => (string) Str::uuid(),
            'code' => 'TESTCOMP',
            'name' => 'Starkids Medical Center',
            'email' => 'test@starkids.com',
            'phone' => '081234567890',
            'website' => 'starkids.com',
            'is_active' => true,
        ]);

        $this->oneHealthy = OneHealthy::create([
            'company_id' => $this->company->id,
            'organization_id' => Crypt::encryptString('org-123'),
            'client_id' => Crypt::encryptString('client-123'),
            'client_secret' => Crypt::encryptString('secret-123'),
        ]);

        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
        ]);

        $role = Role::firstOrCreate(['name' => 'Dokter', 'guard_name' => 'web']);
        RoleCompany::firstOrCreate([
            'role_id' => $role->uuid ?? $role->id,
            'company_id' => $this->company->id,
        ]);
    }

    public function test_api_practitioner_found_by_nik(): void
    {
        Http::fake([
            '*/oauth2/v1/accesstoken*' => Http::response([
                'access_token' => 'mock-token-123',
            ], 200),
            '*/fhir-r4/v1/Practitioner*' => Http::response([
                'resourceType' => 'Bundle',
                'total' => 1,
                'entry' => [
                    [
                        'fullUrl' => 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Practitioner/10002967812',
                        'resource' => [
                            'resourceType' => 'Practitioner',
                            'id' => '10002967812',
                            'identifier' => [
                                [
                                    'system' => 'https://fhir.kemkes.go.id/id/nik',
                                    'use' => 'official',
                                    'value' => '3578150204840002',
                                ],
                            ],
                            'name' => [
                                [
                                    'use' => 'official',
                                    'text' => 'dr. Felix Setiawan, Sp.A',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = app(apiservice::class)->getPratition([
            'company_id' => $this->company->id,
            'nik' => '3578150204840002',
            'name' => 'dr. Felix Setiawan, Sp.A',
        ]);

        $this->assertTrue($response['success']);
        $this->assertEquals('10002967812', $response['data']['id_practitioner']);
        $this->assertEquals('dr. Felix Setiawan, Sp.A', $response['data']['name']);
        $this->assertNotEmpty($response['data']['practitioner_id']);
    }

    public function test_api_practitioner_not_found(): void
    {
        Http::fake([
            '*/oauth2/v1/accesstoken*' => Http::response([
                'access_token' => 'mock-token-123',
            ], 200),
            '*/fhir-r4/v1/Practitioner*' => Http::response([
                'resourceType' => 'Bundle',
                'total' => 0,
                'entry' => [],
            ], 200),
        ]);

        $response = app(apiservice::class)->getPratition([
            'company_id' => $this->company->id,
            'nik' => '1111222233334444',
            'name' => 'Dokter Palsu',
        ]);

        $this->assertFalse($response['success']);
        $this->assertEquals('Data praktisi tidak ditemukan di SatuSehat', $response['message']);
    }

    public function test_get_by_nik_endpoint_success(): void
    {
        Http::fake([
            '*/oauth2/v1/accesstoken*' => Http::response([
                'access_token' => 'mock-token-123',
            ], 200),
            '*/fhir-r4/v1/Practitioner*' => Http::response([
                'resourceType' => 'Bundle',
                'total' => 1,
                'entry' => [
                    [
                        'fullUrl' => 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Practitioner/10002967812',
                        'resource' => [
                            'resourceType' => 'Practitioner',
                            'id' => '10002967812',
                            'identifier' => [
                                [
                                    'system' => 'https://fhir.kemkes.go.id/id/nik',
                                    'use' => 'official',
                                    'value' => '3578150204840002',
                                ],
                            ],
                            'name' => [
                                [
                                    'use' => 'official',
                                    'text' => 'dr. Felix Setiawan, Sp.A',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/testing/practitiont/get-by-nik?'.http_build_query([
            'company_id' => $this->company->id,
            'nik' => '3578150204840002',
            'name' => 'dr. Felix Setiawan, Sp.A',
        ]));

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.id_practitioner', '10002967812');
        $response->assertJsonPath('data.name', 'dr. Felix Setiawan, Sp.A');
    }

    public function test_livewire_doctor_search_nik_and_modal_inputs_enabled(): void
    {
        Http::fake([
            '*/oauth2/v1/accesstoken*' => Http::response([
                'access_token' => 'mock-token-123',
            ], 200),
            '*/fhir-r4/v1/Practitioner*' => Http::response([
                'resourceType' => 'Bundle',
                'total' => 1,
                'entry' => [
                    [
                        'fullUrl' => 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Practitioner/10002967812',
                        'resource' => [
                            'resourceType' => 'Practitioner',
                            'id' => '10002967812',
                            'identifier' => [
                                [
                                    'system' => 'https://fhir.kemkes.go.id/id/nik',
                                    'use' => 'official',
                                    'value' => '3578150204840002',
                                ],
                            ],
                            'name' => [
                                [
                                    'use' => 'official',
                                    'text' => 'dr. Felix Setiawan, Sp.A',
                                ],
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        Livewire::actingAs($this->user)
            ->test(AdminMasterDoctorIndex::class)
            ->set('nik', '3578150204840002')
            ->call('searchNik')
            ->assertSet('doctor_id', '10002967812')
            ->assertSee('Terhubung SatuSehat')
            ->assertSee('10002967812')
            ->assertDontSee('disabled wire:model.defer="administrative_gender"')
            ->assertDontSee('disabled autocomplete="false" id="birth_date"')
            ->set('phone', '081234567891')
            ->set('password', 'password123')
            ->set('address', 'Jl. Test No. 123')
            ->set('license_number', 'STR-123456')
            ->set('sip_number', 'SIP-123456')
            ->set('specialization', 'Spesialis Anak')
            ->set('doctor_type', 'specialist')
            ->set('administrative_gender', 'male')
            ->set('birth_date', '1984-04-02')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'dr. Felix Setiawan, Sp.A',
            'phone' => '081234567891',
        ]);

        $userDetail = UserDetail::where('doctor_id', '10002967812')->first();
        $this->assertNotNull($userDetail);
        $this->assertEquals('3578150204840002', $userDetail->identity_card);
        $this->assertEquals('male', $userDetail->administrative_gender);
    }
}
