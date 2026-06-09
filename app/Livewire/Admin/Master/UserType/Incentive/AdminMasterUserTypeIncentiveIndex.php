<?php

namespace App\Livewire\Admin\Master\UserType\Incentive;

use App\Helpers\AlertHelper;
use App\Models\User\UserType;
use App\Models\User\UserTypeIncentive;
use DB;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class AdminMasterUserTypeIncentiveIndex extends Component
{
    use WithPagination;
    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];
    public $perPage = 5;
    public $search = '';
    public $user_types = [];
    public $data_id;
    public $name;
    public $description;
    public $user_type_id;
    public $price_min,
        $price_max,
        $incentive_value,
        $incentive_type;

    public function mount()
    {
        $this->user_types = UserType::all()->pluck('name', 'id')->toArray();
    }

    public function openModal()
    {
        $this->incentive_type = 'rupiah'; // Default incentive type
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->reset(['data_id', 'name', 'description', 'user_type_id', 'price_min', 'price_max', 'incentive_value', 'incentive_type']);
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function edit($id)
    {
        $poly = UserTypeIncentive::findOrFail($id);
        $this->data_id = $poly->id;
        $this->name = $poly->name;
        $this->description = $poly->description;
        $this->user_type_id = $poly->user_type_id;
        $this->price_min = number_format($poly->price_min, 0, ',', '.');
        $this->price_max = number_format($poly->price_max, 0, ',', '.');
        $this->incentive_value = number_format($poly->incentive_value, 0, ',', '.');
        $this->incentive_type = $poly->incentive_type;
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Anda Yakin Menghapus Data Ini?', $id);
    }

    public function delete($id)
    {
        $poly = UserTypeIncentive::findOrFail($id[0]);
        $poly->delete();
        return AlertHelper::success('Berhasil Menghapus Data', 'Data Berhasil Dihapus');
    }

    public function updatedIncentiveType(): void
    {
        $this->incentive_value = 0; // Reset incentive value when type changes
        $this->updateIncentiveValue();
    }

    public function updatedIncentiveValue(): void
    {
        $this->updateIncentiveValue();
    }

    public function updateIncentiveValue(): void
    {
        if ($this->incentive_type === 'persen') {
            $this->incentive_value = $this->incentive_value > 100 ? 100 : $this->incentive_value;
        }
    }

    public function submit()
    {

        $this->price_min = $this->price_min ? intval(Str::replace('.', '', $this->price_min)) : 0;
        $this->price_max = $this->price_max ? intval(Str::replace('.', '', $this->price_max)) : null;
        $this->incentive_value = $this->incentive_value ? intval(Str::replace('.', '', $this->incentive_value)) : 0;

        $this->validate([
            'user_type_id' => 'required|exists:user_types,id',
            'price_min' => 'required|numeric',
            'price_max' => 'nullable|numeric|gte:price_min',
            'incentive_value' => 'required|numeric',
            'incentive_type' => 'required|in:persen,rupiah',
            'description' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            UserTypeIncentive::updateOrCreate(
                ['id' => $this->data_id],
                [
                    'description' => $this->description,
                    'user_type_id' => $this->user_type_id,
                    'price_min' => $this->price_min,
                    'price_max' => $this->price_max,
                    'incentive_value' => $this->incentive_value,
                    'incentive_type' => $this->incentive_type,
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
        $userTypeIncentives = UserTypeIncentive::search($this->search)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('livewire.admin.master.user-type.incentive.admin-master-user-type-incentive-index', [
            'userTypeIncentives' => $userTypeIncentives,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
