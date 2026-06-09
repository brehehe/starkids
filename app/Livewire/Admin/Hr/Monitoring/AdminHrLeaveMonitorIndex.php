<?php

namespace App\Livewire\Admin\Hr\Monitoring;

use Livewire\Component;
use App\Models\Leave;
use Livewire\WithPagination;

class AdminHrLeaveMonitorIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $filterStatus = 'all';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function approve($id)
    {
        $leave = Leave::find($id);
        if ($leave && $leave->status === 'pending') {
            $leave->update(['status' => 'approved']);
            $this->js("alert('Cuti disetujui.')");
        }
    }

    public function reject($id)
    {
        $leave = Leave::find($id);
        if ($leave && $leave->status === 'pending') {
            $leave->update(['status' => 'rejected']);
            $this->js("alert('Cuti ditolak.')");
        }
    }

    public function render()
    {
        $leaves = Leave::with('user')
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->latest('created_at')
            ->paginate($this->perPage);

        return view('livewire.admin.hr.monitoring.admin-hr-leave-monitor-index', [
            'leaves' => $leaves
        ])->extends('layout.app')
            ->section('content');
    }
}
