<?php

namespace App\Livewire\Admin\SystemUpdate;

use App\Models\SystemUpdate\SystemUpdate;
use App\Helpers\AlertHelper;
use Livewire\Component;
use Session;

class AdminSystemUpdateDetail extends Component
{
    public $updateId;
    public $title;
    public $content;
    public $type = 'info';
    public $is_active = true;
    public $published_at;

    public $types = [
        'info' => 'Informasi',
        'warning' => 'Peringatan',
        'success' => 'Sukses',
        'danger' => 'Bahaya',
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'type' => 'required|in:info,warning,success,danger',
        'is_active' => 'boolean',
        'published_at' => 'nullable|date',
    ];

    public function mount()
    {
        $this->updateId = Session::get('system_update_id');

        if ($this->updateId) {
            $update = SystemUpdate::findOrFail($this->updateId);
            $this->title = $update->title;
            $this->content = $update->content;
            $this->type = $update->type;
            $this->is_active = $update->is_active;
            $this->published_at = $update->published_at?->format('Y-m-d\TH:i');
        } else {
            $this->published_at = now()->format('Y-m-d\TH:i');
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->updateId) {
            $update = SystemUpdate::findOrFail($this->updateId);
            $update->update([
                'title' => $this->title,
                'content' => $this->content,
                'type' => $this->type,
                'is_active' => $this->is_active,
                'published_at' => $this->published_at,
            ]);

            AlertHelper::success('Update berhasil diperbarui.');
        } else {
            SystemUpdate::create([
                'title' => $this->title,
                'content' => $this->content,
                'type' => $this->type,
                'is_active' => $this->is_active,
                'published_at' => $this->published_at,
            ]);

            AlertHelper::success('Update berhasil dibuat.');
        }

        return redirect()->route('admin.system-update.index');
    }

    public function cancel()
    {
        Session::forget('system_update_id');
        return redirect()->route('admin.system-update.index');
    }

    public function render()
    {
        return view('livewire.admin.system-update.admin-system-update-detail')
            ->extends('layout.app')
            ->section('content');
    }
}
