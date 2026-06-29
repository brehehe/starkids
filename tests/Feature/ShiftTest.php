<?php

namespace Tests\Feature;

use App\Livewire\Admin\Hr\Shift\AdminHrShiftIndex;
use App\Models\Company\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShiftTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_shift(): void
    {
        $company = Company::create([
            'name' => 'Test Company',
            'code' => 'TEST',
            'email' => 'test@company.com',
            'phone' => '08123456789',
            'is_main' => true,
        ]);

        $user = User::factory()->create([
            'company_id' => $company->id,
            'type_user' => 'employee',
        ]);

        Livewire::actingAs($user)
            ->test(AdminHrShiftIndex::class)
            ->set('name', 'Morning Shift')
            ->set('clock_in_time', '08:00')
            ->set('clock_out_time', '17:00')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('shifts', [
            'name' => 'Morning Shift',
            'clock_in_time' => '08:00:00',
            'clock_out_time' => '17:00:00',
            'company_id' => $company->id,
        ]);
    }
}
