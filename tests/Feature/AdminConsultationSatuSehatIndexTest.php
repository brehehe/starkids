<?php

namespace Tests\Feature;

use App\Livewire\Admin\Consultation\SatuSehat\AdminConsultationSatuSehatIndex;
use App\Models\Api\ApiOutboxTask;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Encounter\Encounter;
use App\Models\Patient\OneHealth\OneHealthPatient;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
use App\Models\Role;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminConsultationSatuSehatIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Company
        $company = Company::create([
            'id' => '01987918-8494-73e4-ad37-a6ac4934d586',
            'name' => 'Starkids Medical Center',
            'code' => 'Strkds',
            'email' => 'starkids@example.com',
            'phone' => '081234567890',
            'is_main' => true,
        ]);

        // Create Branch for this Company
        Branch::create([
            'company_id' => $company->id,
            'name' => 'Starkids Branch Utama',
        ]);
        // Create Role
        $role = \App\Models\Spatie\Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        // Create User
        $user = User::factory()->create([
            'company_id' => $company->id,
            'name' => 'Admin User',
            'type_user' => 'employee',
        ]);

        // Assign Role
        UserCompanyRole::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'role_id' => $role->uuid,
            'is_active' => true,
        ]);
    }

    public function test_route_can_be_accessed_by_authenticated_user(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->get('/user/consultation/satusehat');

        $response->assertStatus(200);
        $response->assertSeeLivewire(AdminConsultationSatuSehatIndex::class);
    }

    public function test_component_can_render_properly(): void
    {
        $user = User::first();

        Livewire::actingAs($user)
            ->test(AdminConsultationSatuSehatIndex::class)
            ->assertStatus(200)
            ->assertSet('tab', 'patient')
            ->call('changeTab', 'encounter')
            ->assertSet('tab', 'encounter')
            ->call('changeTab', 'outbox')
            ->assertSet('tab', 'outbox');
    }

    public function test_displays_dynamic_outbox_statuses(): void
    {
        $company = Company::first();

        // Create Patient Role if it doesn't exist
        $patientRole = \App\Models\Spatie\Role::firstOrCreate([
            'name' => 'Pasien',
            'guard_name' => 'web',
        ]);

        // Create Patient User
        $patientUser = User::factory()->create([
            'company_id' => $company->id,
            'name' => 'John Doe Patient',
            'type_user' => 'patient',
        ]);

        UserCompanyRole::create([
            'user_id' => $patientUser->id,
            'company_id' => $company->id,
            'role_id' => $patientRole->uuid,
            'is_active' => true,
        ]);

        // Create UserDetail record
        UserDetail::create([
            'user_id' => $patientUser->id,
            'identity_card' => '1234567890123456',
            'administrative_gender' => 'male',
            'birth_date' => '1990-01-01',
        ]);

        // Create Patient model
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'name' => 'John Doe Patient',
            'identity_card' => '1234567890123456',
        ]);

        // Create OneHealthPatient
        $ohPatient = OneHealthPatient::create([
            'patient_id' => $patient->id,
            'active' => true,
            'name_text' => 'John Doe Patient',
            'gender' => 'male',
        ]);

        // Create a failed outbox task
        ApiOutboxTask::create([
            'model_classes' => ['App\Models\Patient\OneHealth\OneHealthPatient'],
            'model_ids' => [$ohPatient->id],
            'service_class' => 'App\Services\OneHealth\Patient\PatientService',
            'service_method' => 'postPutPatient',
            'request_body' => json_encode(['foo' => 'bar']),
            'response_body' => json_encode(['error' => 'NIK invalid']),
            'status' => 'failed',
            'execution' => 1,
        ]);

        $adminUser = User::where('name', 'Admin User')->first();

        // Test that Livewire component sees this outbox status map and displays "Gagal Sync" with error title
        Livewire::actingAs($adminUser)
            ->test(AdminConsultationSatuSehatIndex::class)
            ->assertStatus(200)
            ->assertSee('Gagal Sync')
            ->assertSee('NIK invalid');
    }

    public function test_can_clear_all_tasks(): void
    {
        $adminUser = User::where('name', 'Admin User')->first();

        // Create mock outbox tasks
        ApiOutboxTask::create([
            'model_classes' => ['App\Models\Patient\OneHealth\OneHealthPatient'],
            'model_ids' => ['01987918-8494-73e4-ad37-a6ac4934d586'],
            'service_class' => 'App\Services\OneHealth\Patient\PatientService',
            'service_method' => 'postPutPatient',
            'request_body' => json_encode(['foo' => 'bar']),
            'status' => 'failed',
            'execution' => 1,
        ]);

        ApiOutboxTask::create([
            'model_classes' => ['App\Models\Patient\OneHealth\OneHealthPatient'],
            'model_ids' => ['01987918-8494-73e4-ad37-a6ac4934d587'],
            'service_class' => 'App\Services\OneHealth\Patient\PatientService',
            'service_method' => 'postPutPatient',
            'request_body' => json_encode(['foo' => 'baz']),
            'status' => 'pending',
            'execution' => 0,
        ]);

        $this->assertEquals(2, ApiOutboxTask::count());

        Livewire::actingAs($adminUser)
            ->test(AdminConsultationSatuSehatIndex::class)
            ->call('clearAllTasks');

        $this->assertEquals(0, ApiOutboxTask::count());
    }

    public function test_can_clear_success_tasks(): void
    {
        $adminUser = User::where('name', 'Admin User')->first();

        ApiOutboxTask::create([
            'model_classes' => ['App\Models\Patient\OneHealth\OneHealthPatient'],
            'model_ids' => ['01987918-8494-73e4-ad37-a6ac4934d586'],
            'service_class' => 'App\Services\OneHealth\Patient\PatientService',
            'service_method' => 'postPutPatient',
            'request_body' => json_encode(['foo' => 'bar']),
            'status' => 'success',
            'execution' => 1,
        ]);

        ApiOutboxTask::create([
            'model_classes' => ['App\Models\Patient\OneHealth\OneHealthPatient'],
            'model_ids' => ['01987918-8494-73e4-ad37-a6ac4934d587'],
            'service_class' => 'App\Services\OneHealth\Patient\PatientService',
            'service_method' => 'postPutPatient',
            'request_body' => json_encode(['foo' => 'baz']),
            'status' => 'failed',
            'execution' => 1,
        ]);

        $this->assertEquals(2, ApiOutboxTask::count());

        Livewire::actingAs($adminUser)
            ->test(AdminConsultationSatuSehatIndex::class)
            ->call('clearSuccessTasks');

        $this->assertEquals(1, ApiOutboxTask::count());
        $this->assertEquals('failed', ApiOutboxTask::first()->status);
    }

    public function test_can_clear_failed_tasks(): void
    {
        $adminUser = User::where('name', 'Admin User')->first();

        ApiOutboxTask::create([
            'model_classes' => ['App\Models\Patient\OneHealth\OneHealthPatient'],
            'model_ids' => ['01987918-8494-73e4-ad37-a6ac4934d586'],
            'service_class' => 'App\Services\OneHealth\Patient\PatientService',
            'service_method' => 'postPutPatient',
            'request_body' => json_encode(['foo' => 'bar']),
            'status' => 'success',
            'execution' => 1,
        ]);

        ApiOutboxTask::create([
            'model_classes' => ['App\Models\Patient\OneHealth\OneHealthPatient'],
            'model_ids' => ['01987918-8494-73e4-ad37-a6ac4934d587'],
            'service_class' => 'App\Services\OneHealth\Patient\PatientService',
            'service_method' => 'postPutPatient',
            'request_body' => json_encode(['foo' => 'baz']),
            'status' => 'failed',
            'execution' => 1,
        ]);

        $this->assertEquals(2, ApiOutboxTask::count());

        Livewire::actingAs($adminUser)
            ->test(AdminConsultationSatuSehatIndex::class)
            ->call('clearFailedTasks');

        $this->assertEquals(1, ApiOutboxTask::count());
        $this->assertEquals('success', ApiOutboxTask::first()->status);
    }

    public function test_can_queue_all_syncable_encounters(): void
    {
        $adminUser = User::where('name', 'Admin User')->first();
        $this->actingAs($adminUser);

        // Mock apiservice class for createTransaction and createUser
        $this->mock(apiservice::class, function ($mock) {
            $mock->shouldReceive('createTransaction')->andReturn([
                'success' => true,
            ]);
            $mock->shouldReceive('createUser')->andReturn([
                'success' => true,
            ]);
        });

        // Create a Patient user with role and patient details
        $company = Company::first();
        $patientRole = \App\Models\Spatie\Role::firstOrCreate([
            'name' => 'Pasien',
            'guard_name' => 'web',
        ]);
        $patientUser = User::factory()->create([
            'company_id' => $company->id,
            'name' => 'John Doe Patient',
            'type_user' => 'patient',
        ]);
        UserCompanyRole::create([
            'user_id' => $patientUser->id,
            'company_id' => $company->id,
            'role_id' => $patientRole->uuid,
            'is_active' => true,
        ]);
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'name' => 'John Doe Patient',
            'identity_card' => '1234567890123456',
        ]);
        // Patient has id_patient (meaning synced)
        OneHealthPatient::create([
            'patient_id' => $patient->id,
            'id_patient' => 'P123456789',
            'active' => true,
            'name_text' => 'John Doe Patient',
            'gender' => 'male',
        ]);

        // Create Practitioner user
        $practitionerUser = User::factory()->create([
            'company_id' => $company->id,
            'name' => 'Dr. Stranger',
            'type_user' => 'employee',
        ]);
        Practitioner::create([
            'user_id' => $practitionerUser->id,
            'id_practitioner' => 'D987654321',
            'name_text' => 'Dr. Stranger',
            'active' => true,
        ]);

        // Create transaction
        $transaction = Transaction::create([
            'company_id' => $company->id,
            'patient_id' => $patientUser->id,
            'doctor_id' => $practitionerUser->id,
            'date' => '2026-07-10',
            'code' => 'TX-20260710-001',
        ]);

        // Create encounter
        $encounter = Encounter::create([
            'transaction_id' => $transaction->id,
            'status' => 'planned',
            'class_code' => 'AMB',
        ]);

        // Test calling queueAllSyncableEncounters on component
        Livewire::actingAs($adminUser)
            ->test(AdminConsultationSatuSehatIndex::class)
            ->call('changeTab', 'encounter')
            ->call('queueAllSyncableEncounters')
            ->assertHasNoErrors();
    }
}
