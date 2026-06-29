<?php

namespace App\Livewire\Admin\SystemUpdate;

use App\Helpers\AlertHelper;
use App\Models\SystemUpdate\SystemUpdate;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminSystemUpdateIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 10;

    public function mount()
    {
        Session::forget('system_update_id');
    }

    public function createUpdate()
    {
        return redirect()->route('admin.system-update.detail');
    }

    public function editUpdate($updateId)
    {
        Session::put('system_update_id', $updateId);

        return redirect()->route('admin.system-update.detail');
    }

    public function toggleActive($updateId)
    {
        $update = SystemUpdate::findOrFail($updateId);
        $update->is_active = ! $update->is_active;
        $update->save();

        return AlertHelper::success('Status berhasil diubah.');
    }

    public function confirmDelete($updateId)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus update ini?', $updateId);
    }

    public function delete($id)
    {
        $update = SystemUpdate::findOrFail($id[0]);
        $update->delete();

        return AlertHelper::success('Update berhasil dihapus.');
    }

    public function render()
    {
        $updates = SystemUpdate::search($this->search)
            ->orderBy('order', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.system-update.admin-system-update-index', [
            'updates' => $updates,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
