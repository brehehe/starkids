<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\Login\AuthLoginIndex;
use App\Models\Company\Company;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
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
            'username' => 'starkidsmedicalcenter',
        ]);

        UserCompanyRole::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'role_id' => $role->uuid,
            'is_active' => true,
        ]);

        $response = Livewire::test(AuthLoginIndex::class);
        $captcha = $response->get('captchaCode');

        $response->set('code', 'Strkds')
            ->set('username_or_email', 'starkidsmedicalcenter')
            ->set('password', 'password')
            ->set('captchaInput', $captcha)
            ->call('login');

        $response
            ->assertHasNoErrors()
            ->assertRedirect(route('user.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
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
            'username' => 'starkidsmedicalcenter',
        ]);

        UserCompanyRole::create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'role_id' => $role->uuid,
            'is_active' => true,
        ]);

        $response = Livewire::test(AuthLoginIndex::class);
        $captcha = $response->get('captchaCode');

        $response->set('code', 'Strkds')
            ->set('username_or_email', 'starkidsmedicalcenter')
            ->set('password', 'wrong-password')
            ->set('captchaInput', $captcha)
            ->call('login');

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/logout');

        $response->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
