<?php

namespace App\Livewire\Admin\Master\Banner;

use App\Helpers\AlertHelper;
use App\Models\Banner\Banner;
use Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminMasterBannerIndex extends Component
{
    use WithFileUploads, WithPagination;

    public $perPage = 10;

    public $search = '';

    public $banner_id;

    public $image;

    public $new_image;

    public $is_active = true;

    protected $listeners = ['delete'];

    public function render()
    {
        return view('livewire.admin.master.banner.admin-master-banner-index', [
            'banners' => Banner::query()
                ->where('company_id', Auth::user()->company_id)
                ->when($this->search, function ($query) {
                    // No title to search anymore, maybe search by ID or status if needed?
                    // For now, keeping structure but maybe removing search logic if nothing to search textually?
                    // Or maybe invalid since we removed title. Let's remove search constraint for now or search id?
                })
                ->latest()
                ->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }

    public function openModal()
    {
        $this->dispatch('open-modal');
    }

    public function closeModal()
    {
        $this->reset(['banner_id', 'image', 'new_image', 'is_active']);
        $this->dispatch('close-modal');
    }

    public function create()
    {
        $this->reset(['banner_id', 'image', 'new_image', 'is_active']);
        $this->openModal();
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $this->banner_id = $banner->id;
        $this->image = $banner->image;
        $this->is_active = $banner->is_active;
        $this->openModal();
    }

    public function save()
    {
        $rules = [
            'is_active' => 'boolean',
        ];

        if (! $this->banner_id) {
            $rules['new_image'] = 'required|image|max:2048'; // 2MB Max
        } else {
            $rules['new_image'] = 'nullable|image|max:2048';
        }

        $this->validate($rules);

        $imagePath = $this->image;
        if ($this->new_image) {
            if ($this->image) {
                Storage::delete($this->image);
            }
            $imagePath = $this->new_image->store('banners', 'public');
        }

        Banner::updateOrCreate(
            ['id' => $this->banner_id],
            [
                'company_id' => Auth::user()->company_id,
                'image' => $imagePath,
                'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            ]
        );

        $this->closeModal();
        AlertHelper::success('Banner berhasil disimpan.');
    }

    public function deleteConfirm($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Apakah Anda yakin?',
            'text' => 'Data yang dihapus tidak dapat dikembalikan!',
            'type' => 'warning',
            'confirmButtonText' => 'Ya, hapus!',
            'cancelButtonText' => 'Batal',
            'function' => 'delete',
            'params' => [$id],
        ]);
    }

    public function delete($id)
    {
        $banner = Banner::findOrFail($id[0]);
        if ($banner->image) {
            Storage::delete($banner->image);
        }
        $banner->delete();
        AlertHelper::success('Banner berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => ! $banner->is_active]);
        AlertHelper::success('Status banner berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Anda Yakin Menghapus Data Ini?', $id);
    }
}
