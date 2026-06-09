<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShiftTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_shift(): void
    {
        $company = \App\Models\Company\Company::create([
            'name' => 'Test Company',
            'code' => 'TEST',
            'email' => 'test@company.com',
            'phone' => '08123456789',
            'is_main' => true
        ]);

        $user = \App\Models\User::factory()->create([
            'company_id' => $company->id,
            'type_user' => 'employee'
        ]);

        \Livewire\Livewire::actingAs($user)
            ->test(\App\Livewire\Admin\Hr\Shift\AdminHrShiftIndex::class)
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
