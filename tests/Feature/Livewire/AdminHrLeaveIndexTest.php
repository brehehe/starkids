<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Admin\Hr\Leave\AdminHrLeaveIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminHrLeaveIndexTest extends TestCase
{
    // use RefreshDatabase;

    public function test_can_render_leave_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('user.hr.leave.index'));

        $response->assertStatus(200);
    }

    public function test_can_submit_leave_request()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(AdminHrLeaveIndex::class)
            ->set('type', 'annual')
            ->set('start_date', '2026-04-01')
            ->set('end_date', '2026-04-05')
            ->set('reason', 'Liburan keluarga')
            ->call('submitLeave');

        $this->assertDatabaseHas('leaves', [
            'user_id' => $user->id,
            'type' => 'annual',
            'reason' => 'Liburan keluarga',
            'status' => 'pending',
        ]);
    }
}
