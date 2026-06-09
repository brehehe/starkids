<?php

namespace App\Livewire\Admin\Pharmacy\TakeMedicine;

use App\Helpers\AlertHelper;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionProduct;
use App\Models\Transaction\TransactionRecipe;
use App\Models\User;
use App\Traits\Transaction\ReversesTransactionStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminPharmacyTakeMedicineIndex extends Component
{
    use ReversesTransactionStock, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $perPage = 5;

    protected $queryString = [
        'search' => ['except' => ''],
        'doctor_id' => ['except' => ''],
        'searchPatient' => ['except' => ''],
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
    ];

    public $doctor_id = '';

    public $searchPatient = '';

    public $start_date = '';

    public $end_date = '';

    public function mount()
    {
        Session::forget('transaction_id');

        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');

            return;
        }

        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    // public function hydrate()
    // {
    //     $this->resetPage();
    // }

    public function updatingDoctorId()
    {
        $this->resetPage();
    }

    public function updatingSearchPatient()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function confirmDetail($id)
    {
        return AlertHelper::confirmInfo('detail', 'Apakah Anda Yakin Mengkonfirmasi Pengambilan Obat?', $id);
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus transaksi ini?', $id);
    }

    public function delete($data)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::find($data[0]);
            if ($transaction) {
                // Reverse stock for anything that was decremented
                $this->reverseStockForTransaction($transaction);

                // Clean up child tables
                TransactionRecipe::where('transaction_id', $transaction->id)->delete();
                TransactionDetail::where('transaction_id', $transaction->id)->delete();
                TransactionProduct::where('transaction_id', $transaction->id)->delete();

                $transaction->delete();
                DB::commit();

                return AlertHelper::success('Berhasil', 'Transaksi berhasil dihapus.');
            } else {
                AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus transaksi: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus transaksi.');
        }
    }

    public function detail($id)
    {
        $transaction = Transaction::find($id[0]);
        if ($transaction) {
            Session::put('transaction_id', $transaction->id);

            return redirect()->route('user.pharmacy.take-medicine.detail');
        } else {
            AlertHelper::error('Error', 'Transaksi tidak ditemukan.');
        }
    }

    public function render()
    {
        $doctors = User::companyRole('Dokter', auth()->user()->company_id)->get();

        $transactions = Transaction::search($this->search)
            // ->where('consultation', 'yes')
            ->whereIn('status', ['take_medicine', 'completed'])
            ->where('is_take_medicine', true)
            ->when($this->doctor_id, function ($query) {
                $query->where('doctor_id', $this->doctor_id);
            })
            ->when($this->searchPatient, function ($query) {
                $query->where('patient_name', 'ilike', '%'.$this->searchPatient.'%');
            })
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereDate('created_at', '>=', $this->start_date)
                    ->whereDate('created_at', '<=', $this->end_date);
            })
            ->orderBy('created_at', 'desc')
            ->where('company_id', auth()->user()->company_id)
            ->paginate($this->perPage);

        return view('livewire.admin.pharmacy.take-medicine.admin-pharmacy-take-medicine-index', [
            'transactions' => $transactions,
            'doctors' => $doctors,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
