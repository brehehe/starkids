<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminHrAttendanceIndexTest extends TestCase
{
    // use RefreshDatabase;

    public function test_can_render_attendance_page()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('user.hr.attendance.index'));

        $response->assertStatus(200);
    }

    public function test_can_clock_in()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        \Livewire\Livewire::test(\App\Livewire\Admin\Hr\Attendance\AdminHrAttendanceIndex::class)
            ->set('photo', 'data:image/jpeg;base64,xxxxxxxxxxxxxxx')
            ->set('latitude', -6.200000)
            ->set('longitude', 106.816666)
            ->call('clockIn');

        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'status' => 'present',
        ]);
    }
}
