<?php

namespace App\Livewire\Admin\Master\Insurance;

use App\Helpers\AlertHelper;
use App\Models\Insurance\Insurance;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMasterInsuranceIndex extends Component
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

    public $code;

    public $description;

    public function openModal()
    {
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->reset(['data_id', 'name', 'code', 'description']);
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function edit($id)
    {
        $insurance = Insurance::findOrFail($id);
        $this->data_id = $insurance->id;
        $this->name = $insurance->name;
        $this->code = $insurance->code;
        $this->description = $insurance->description;

        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Anda Yakin Menghapus Data Ini?', $id);
    }

    public function delete($id)
    {
        $insurance = Insurance::findOrFail($id[0]);
        $insurance->delete();

        return AlertHelper::success('Berhasil Menghapus Data', 'Data Berhasil Dihapus');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Insurance::updateOrCreate(
            ['id' => $this->data_id],
            [
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
            ]
        );

        $this->closeModal();

        return AlertHelper::success('Berhasil', 'Data Berhasil Disimpan');
    }

    public function render()
    {
        $insurances = Insurance::query()
            ->where('company_id', auth()->user()->company_id)
            ->when($this->search, function ($query) {
                $query->where('name', 'ilike', '%'.$this->search.'%');
            })
            ->orderBy('order', 'asc')
            ->paginate($this->perPage);

        return view('livewire.admin.master.insurance.admin-master-insurance-index', [
            'insurances' => $insurances,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
