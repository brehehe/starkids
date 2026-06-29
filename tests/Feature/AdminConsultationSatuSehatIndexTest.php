<?php

namespace Tests\Feature;

use App\Livewire\Admin\Consultation\SatuSehat\AdminConsultationSatuSehatIndex;
use App\Models\Company\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\User\UserCompanyRole;
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
}
