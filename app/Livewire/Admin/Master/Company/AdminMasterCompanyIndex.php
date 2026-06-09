<?php

namespace App\Livewire\Admin\Master\Company;

use App\Helpers\AlertHelper;
use App\Models\Company\Company;
use Livewire\Component;
use Livewire\WithPagination;
use Session;
use DB;
use Illuminate\Support\Facades\Log;

class AdminMasterCompanyIndex extends Component
{
    use WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    public function mount()
    {
        Session::forget('stock_mutation_id');

        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');

            return;
        }
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda Yakin Ingin Menghapus Data Ini?', $id);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $company = Company::findOrFail($id[0]);
            $company->delete();
            DB::commit();
            AlertHelper::success('Data Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            AlertHelper::error('Data Gagal Dihapus');
            return Log::error('Error deleting company: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        Session::put('company_id', $id);
        return redirect()->route('user.master.company.detail');
    }

    public function render()
    {
        $companys = Company::search($this->search)
            ->orderBy('order', 'asc')
            ->where('company_id', auth()->user()->company_id)
            ->paginate($this->perPage);

        return view('livewire.admin.master.company.admin-master-company-index', [
            'companys' => $companys,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
