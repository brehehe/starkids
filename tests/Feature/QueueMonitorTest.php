<?php

namespace Tests\Feature;

use App\Livewire\Admin\Queue\AdminQueueMonitorIndex;
use App\Models\Company\Company;
use App\Models\Location\Location;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Models\User\ControlDoctor;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class QueueMonitorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup initial data
        $this->company = Company::factory()->create(['name' => 'Starkids Medical Center']);
        $this->user = User::factory()->create([
            'company_id' => $this->company->id,
            'type_user' => 'admin',
        ]);

        $this->doctor = User::factory()->create([
            'company_id' => $this->company->id,
            'type_user' => 'employee',
        ]);

        $this->location = Location::create([
            'company_id' => $this->company->id,
            'name' => 'Poli Umum',
            'status' => 'active',
            'mode' => 'instance',
            'physical_type' => 'ro',
        ]);

        // Map English day to Indonesian
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];
        $todayIndo = $dayMap[Carbon::now()->format('l')];

        $this->schedule = ControlDoctor::create([
            'company_id' => $this->company->id,
            'user_id' => $this->doctor->id,
            'location_id' => $this->location->id,
            'days' => json_encode([$todayIndo]),
            'start_time' => '08:00',
            'end_time' => '17:00',
            'max_patients' => 20,
        ]);
    }

    public function test_queue_monitor_page_is_accessible()
    {
        $response = $this->actingAs($this->user)->get(route('queue.monitor'));
        $response->assertStatus(200);
    }

    public function test_queue_monitor_displays_scheduled_poly()
    {
        Livewire::actingAs($this->user)
            ->test(AdminQueueMonitorIndex::class)
            ->assertSee('Poli Umum')
            ->assertSee($this->doctor->name);
    }

    public function test_queue_monitor_updates_when_patient_is_called()
    {
        $patient = User::factory()->create(['company_id' => $this->company->id]);

        $transaction = Transaction::create([
            'company_id' => $this->company->id,
            'branch_id' => $this->location->company_id, // Assuming same for test
            'patient_id' => $patient->id,
            'doctor_id' => $this->doctor->id,
            'location_id' => $this->location->id,
            'control_doctor_id' => $this->schedule->id,
            'status' => 'call_consultation',
            'order' => 5,
            'date' => Carbon::today(),
        ]);

        Livewire::actingAs($this->user)
            ->test(AdminQueueMonitorIndex::class)
            ->call('updateQueues')
            ->assertSee('5')
            ->assertSee($patient->name)
            ->assertSee('SILAHKAN MASUK');
    }
}
