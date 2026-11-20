<?php

namespace Tests\Feature;

use App\Livewire\Admin\Dashboard\AdminDashboardIndex;
use App\Models\Company\Company;
use App\Models\Spatie\Role;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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

    public function test_doctor_only_sees_their_own_data_on_dashboard(): void
    {
        $company = Company::create([
            'name' => 'Starkids Medical Center',
            'code' => 'Strkds',
            'email' => 'starkids@example.com',
            'phone' => '081234567890',
            'is_main' => true,
        ]);

        $roleDokter = Role::create([
            'name' => 'Dokter',
            'guard_name' => 'web',
        ]);

        $doctorA = User::factory()->create([
            'name' => 'dr. Felix',
            'type_user' => 'employee',
            'email_verified_at' => now(),
            'company_id' => $company->id,
        ]);
        $doctorA->assignRole($roleDokter);

        $doctorB = User::factory()->create([
            'name' => 'dr. Budi',
            'type_user' => 'employee',
            'email_verified_at' => now(),
            'company_id' => $company->id,
        ]);
        $doctorB->assignRole($roleDokter);

        $trxA = Transaction::create([
            'code' => 'TRX-DOC-A',
            'company_id' => $company->id,
            'doctor_id' => $doctorA->id,
            'status' => 'completed',
            'grand_total_price' => 150000,
            'type' => 'konsultasi',
            'created_at' => now(),
        ]);

        $trxB = Transaction::create([
            'code' => 'TRX-DOC-B',
            'company_id' => $company->id,
            'doctor_id' => $doctorB->id,
            'status' => 'completed',
            'grand_total_price' => 300000,
            'type' => 'konsultasi',
            'created_at' => now(),
        ]);

        Livewire::actingAs($doctorA)
            ->test(AdminDashboardIndex::class)
            ->assertViewHas('isDoctor', true)
            ->assertViewHas('todayRevenue', 150000)
            ->assertViewHas('todayTransactions', 1)
            ->assertSee('TRX-DOC-A')
            ->assertDontSee('TRX-DOC-B');
    }

    public function test_notifications_are_hidden_for_doctor(): void
    {
        $company = Company::create([
            'name' => 'Starkids Medical Center',
            'code' => 'Strkds',
            'email' => 'starkids@example.com',
            'phone' => '081234567890',
            'is_main' => true,
        ]);

        $roleDokter = Role::create([
            'name' => 'Dokter',
            'guard_name' => 'web',
        ]);

        $doctor = User::factory()->create([
            'name' => 'dr. Felix',
            'type_user' => 'employee',
            'email_verified_at' => now(),
            'company_id' => $company->id,
        ]);
        $doctor->assignRole($roleDokter);

        // When doctor visits /user, notifications bell and sidebar link should be hidden
        $response = $this->actingAs($doctor)->get('/user');
        $response->assertStatus(200);
        $response->assertDontSee('user.notifications.list');
        $response->assertDontSee('Tandai Semua Dibaca');

        // Notification API returns empty for doctor
        $apiResponse = $this->actingAs($doctor)->getJson('/user/notifications');
        $apiResponse->assertStatus(200)
            ->assertJson([
                'notifications' => [],
                'unreadCount' => 0,
            ]);
    }
}
