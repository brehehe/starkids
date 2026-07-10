<?php

namespace App\Livewire\Admin\Master\Deposit;

use App\Helpers\AlertHelper;
use App\Models\Deposit\Deposit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMasterDepositIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $perPage = 10;

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    public $statusFilter = '';

    public $dateFrom = '';

    public $dateTo = '';

    // Statistics
    public $totalDeposits = 0;

    public $totalAmount = 0;

    public $totalPaid = 0;

    public $totalRemaining = 0;

    public function mount()
    {
        $this->dateFrom = date('Y-m-01'); // First day of current month
        $this->dateTo = date('Y-m-t'); // Last day of current month
        $this->loadStatistics();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
        $this->loadStatistics();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
        $this->loadStatistics();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function loadStatistics()
    {
        $companyId = Auth::user()->company_id;

        $query = Deposit::byCompany($companyId);

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $deposits = $query->get();

        $this->totalDeposits = $deposits->count();
        $this->totalAmount = $deposits->sum('grand_total_price');
        $this->totalPaid = $deposits->sum(function ($deposit) {
            return $deposit->grand_total_price - $deposit->remaining_bill;
        });
        $this->totalRemaining = $deposits->sum('remaining_bill');
    }

    public function createDeposit()
    {
        return redirect()->route('user.master.deposit.create');
    }

    public function editDeposit($id)
    {
        // Check if deposit is editable
        if (! $this->isDepositEditable($id)) {
            AlertHelper::error('Error', 'Deposit yang sudah lunas tidak dapat diubah');

            return;
        }

        return redirect()->route('user.master.deposit.detail', ['id' => $id]);
    }

    public function isDepositEditable($id)
    {
        $deposit = Deposit::find($id);

        if (! $deposit) {
            return false;
        }

        // Check if user has access
        if ($deposit->company_id !== Auth::user()->company_id) {
            return false;
        }

        // Check if deposit is completed/paid
        if ($deposit->status === 'success') {
            return false;
        }

        return true;
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('deleteDeposit', 'Deposit yang sudah lunas tidak dapat dihapus', $id);
    }

    public function deleteDeposit($id)
    {
        try {
            DB::beginTransaction();

            $deposit = Deposit::findOrFail($id[0]);

            // Check if user can delete
            if ($deposit->company_id !== Auth::user()->company_id) {
                throw new \Exception('Tidak memiliki akses untuk menghapus deposit ini');
            }

            // Delete related records
            $deposit->depositItems()->delete();
            $deposit->depositPayments()->delete();
            $deposit->depositRecipes()->delete();

            // Delete deposit
            $deposit->delete();

            DB::commit();

            $this->loadStatistics();
            AlertHelper::success('Berhasil', 'Deposit berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting deposit: '.$e->getMessage());
            AlertHelper::error('Error', 'Gagal menghapus deposit: '.$e->getMessage());
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'dateFrom', 'dateTo']);
        $this->dateFrom = date('Y-m-01');
        $this->dateTo = date('Y-m-t');
        $this->loadStatistics();
        $this->resetPage();
    }

    public function render()
    {
        $query = Deposit::with(['patient', 'userType', 'depositItems', 'depositPayments', 'createdBy'])
            ->byCompany(Auth::user()->company_id);

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('code', 'ilike', '%'.$this->search.'%')
                    ->orWhere('text', 'ilike', '%'.$this->search.'%')
                    ->orWhere('description', 'ilike', '%'.$this->search.'%')
                    ->orWhereHas('patient', function ($patientQuery) {
                        $patientQuery->where('name', 'ilike', '%'.$this->search.'%')
                            ->orWhere('phone', 'ilike', '%'.$this->search.'%');
                    });
            });
        }

        // Status filter
        if ($this->statusFilter) {
            $query->byStatus($this->statusFilter);
        }

        // Date filter
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $deposits = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.master.deposit.admin-master-deposit-index', [
            'deposits' => $deposits,
        ])->extends('layout.app')->section('content');
    }
}
