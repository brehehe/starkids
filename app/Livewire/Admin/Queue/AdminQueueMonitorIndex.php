<?php

namespace App\Livewire\Admin\Queue;

use App\Models\Location\Location;
use App\Models\Transaction\Transaction;
use App\Models\User\ControlDoctor;
use Carbon\Carbon;
use Livewire\Component;

class AdminQueueMonitorIndex extends Component
{
    public $queues = [];

    public $currentTime;

    public function mount()
    {
        $this->updateQueues();
    }

    public function updateQueues()
    {
        $this->currentTime = now()->format('H:i');

        // Map English Carbon days to Indonesian as used in ControlDoctor
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

        // Get active schedules for today
        $schedules = ControlDoctor::with(['user', 'location'])
            ->where('days', 'like', '%'.$todayIndo.'%')
            ->get();

        $this->queues = $schedules->map(function ($schedule) {
            // Get the transaction currently being called or in consultation for this doctor at this location
            $currentCall = Transaction::where('location_id', $schedule->location_id)
                ->where('control_doctor_id', $schedule->id)
                ->whereIn('status', ['call_consultation', 'confirmation_call', 'consultation'])
                ->whereDate('date', Carbon::today())
                ->with('patient')
                ->latest()
                ->first();

            return [
                'id' => $currentCall->id ?? null,
                'poly_name' => $schedule->location->name ?? 'Poli',
                'doctor_name' => $schedule->user->name ?? 'Dokter',
                'current_queue' => $currentCall ? $currentCall->code_consultation : '-',
                'patient_name' => $currentCall ? $currentCall->patient->name : '-',
                'status' => $currentCall ? $currentCall->status : 'Kosong',
            ];
        });
    }

    public function render()
    {
        return view('livewire.admin.queue.admin-queue-monitor-index')
            ->extends('layout.tv')
            ->section('content');
    }
}
