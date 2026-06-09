<?php

namespace App\Livewire\Admin\Notification;

use App\Models\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminNotificationIndex extends Component
{
    use WithPagination;

    public $status = 'unread'; // 'all', 'unread', 'read'
    public $search = '';

    public function mount()
    {
        // Check if status is passed in query string? Not needed strictly.
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update(['is_read' => true, 'read_at' => now()]);
            // dispatch event if needed to update navbar
            $this->dispatch('notificationCheckRequired');
        }
    }

    public function markAllRead()
    {
         Notification::where('company_id', Auth::user()->company_id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

         $this->dispatch('notificationCheckRequired');
    }

    public function deleteAll()
    {
         Notification::where('company_id', Auth::user()->company_id)->delete();

         $this->dispatch('notificationCheckRequired');
         session()->flash('message', 'Semua notifikasi berhasil dihapus.');
    }

    public function runCheck()
    {
        // Call the artisan commands
        Artisan::call('check:product-expiry');
        Artisan::call('check:pending-payment');
        Artisan::call('run:defecta');

        // You might want to display the output?
        // $output = Artisan::output();

        session()->flash('message', 'Pengecekan notifikasi berhasil dijalankan.');
        $this->resetPage();
    }

    public function render()
    {
        $query = Notification::where('company_id', Auth::user()->company_id) ->whereNotNull('title')
            ->whereNotNull('data') // Filter out empty notifications
            ->whereNotNull('type');

        if ($this->status === 'unread') {
            $query->where('is_read', false);
        } elseif ($this->status === 'read') {
            $query->where('is_read', true);
        }

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        }

        $notifications = $query->latest()->paginate(10);

        return view('livewire.admin.notification.admin-notification-index', [
            'notifications' => $notifications
        ])
        ->extends('layout.app')
        ->section('content');
    }
}
