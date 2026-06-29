<?php

namespace Tests\Feature;

use App\Models\Company\Company;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_login_page(): void
    {
        $response = $this->get('/user');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $company = Company::create([
            'name' => 'Starkids Medical Center',
            'code' => 'Strkds',
            'email' => 'starkids@example.com',
            'phone' => '081234567890',
            'is_main' => true,
        ]);

        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create([
            'type_user' => 'employee',
            'email_verified_at' => now(),
            'company_id' => $company->id,
        ]);

        UserCompanyRole::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'role_id' => $role->uuid,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/user');
        $response->assertStatus(200);
    }
}
