<?php

namespace App\Livewire\Admin\Master\UserType;

use App\Helpers\AlertHelper;
use App\Models\User;
use App\Models\User\UserType;
use App\Models\User\UserTypeIncentive;
use DB;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class AdminMasterUserTypeIndex extends Component
{
    use WithPagination;
    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];
    public $perPage = 5;
    public $search = '';
    public $data_id;
    public $name;
    public $description;

    public function openModal()
    {
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->reset(['data_id', 'name', 'description']);
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function edit($id)
    {
        $poly = UserType::findOrFail($id);
        $this->data_id = $poly->id;
        $this->name = $poly->name;
        $this->description = $poly->description;
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Anda Yakin Menghapus Data Ini?', $id);
    }

    public function delete($id)
    {
        $poly = UserType::findOrFail($id[0]);

        $userType = UserTypeIncentive::where('user_type_id', $poly->id)->delete();

        $poly->delete();
        return AlertHelper::success('Berhasil Menghapus Data', 'Data Berhasil Dihapus');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $location = UserType::updateOrCreate(
                ['id' => $this->data_id],
                [
                    'name' => $this->name,
                    'description' => $this->description,
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving poly data: ' . $e->getMessage(), [
                'data_id' => $this->data_id,
                'name' => $this->name,
                'description' => $this->description,
            ]);
            return AlertHelper::error('Gagal Menyimpan Data', $e->getMessage());
        }

        $this->closeModal();
        return AlertHelper::success('Berhasil Menyimpan Data', 'Data Berhasil Disimpan');
    }

    public function render()
    {
        $userTypes = UserType::search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.master.user-type.admin-master-user-type-index', [
            'userTypes' => $userTypes,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
