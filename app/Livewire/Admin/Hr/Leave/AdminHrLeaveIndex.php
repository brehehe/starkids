<?php

namespace App\Livewire\Admin\Hr\Leave;

use App\Models\Leave;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminHrLeaveIndex extends Component
{
    use WithFileUploads;

    public $type = 'annual';
    public $start_date;
    public $end_date;
    public $reason;
    public $attachment;

    public function submitLeave()
    {
        $this->validate([
            'type' => 'required|string|in:sick,annual,permission',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('leaves', 'public');
        }

        Leave::create([
            'user_id' => auth()->id(),
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'reason' => $this->reason,
            'attachment_path' => $attachmentPath,
            'status' => 'pending',
        ]);

        $this->reset(['type', 'start_date', 'end_date', 'reason', 'attachment']);
        
        $this->js("alert('Pengajuan ijin/cuti berhasil dikirim.');");
    }

    public function render()
    {
        $leaves = Leave::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.hr.leave.admin-hr-leave-index', [
            'leaves' => $leaves
        ])
        ->extends('layout.app')
        ->section('content');
    }
}
