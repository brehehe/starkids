<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Admin\Hr\Shift\AdminHrShiftIndex;
use App\Models\User;
use Tests\TestCase;

class AdminHrShiftIndexTest extends TestCase
{
    public function test_shift_page_renders_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('user.hr.shift.index'));

        $response->assertStatus(200);
    }

    public function test_can_see_shift_livewire_component(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('user.hr.shift.index'))
            ->assertSeeLivewire(AdminHrShiftIndex::class);
    }
}
