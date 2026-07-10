<?php

namespace App\Livewire\Admin\Consultation\ClaimInsurance;

use App\Helpers\AlertHelper;
use App\Models\Insurance\Insurance;
use App\Models\Location\Location;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminConsultationClaimInsuranceIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $perPage = 5;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $date;

    public $location_id;

    public $locations = [];

    public $is_insurance_claim;

    public $patients = [];

    public $insurances = [];

    public $insurance_id;

    public $patient_id;

    public function mount()
    {
        // $this->date = date('Y-m-d');
        $this->locations = Location::where('company_id', auth()->user()->company_id)
            ->pluck('name', 'id')
            ->toArray();

        $this->insurances = Insurance::where('company_id', auth()->user()->company_id)
            ->pluck('name', 'id')
            ->toArray();

        $this->patients = User::query()
            ->companyRole('Pasien', auth()->user()->company_id)
            ->when($this->search, fn ($q) => $q->where('name', 'ilike', "%{$this->search}%")
            )
            ->pluck('name', 'id')
            ->toArray();

        Session::forget('transaction_id');

        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');

            return;
        }
    }

    public function hydrate()
    {
        $this->resetPage();
    }

    public function confirmCall($id)
    {
        return AlertHelper::confirmWarning('warning', 'Apakah Anda Yakin Memanggil Pasien Ini?', $id);
    }

    public function confirmCallPatient($id)
    {
        return AlertHelper::confirmWarning('callPatient', 'Apakah Anda yakin ingin mengkonfirmasi panggilan pasien ini?', $id);
    }

    public function confirmCancelled($id)
    {
        return AlertHelper::confirmDelete('deleteCancel', 'Apakah Anda yakin ingin membatalkan konsultasi pasien ini?', $id);
    }

    public function confirmConsultation($id)
    {
        return AlertHelper::confirmWarning('konsultasi', 'Apakah Anda yakin ingin memulai konsultasi pasien ini?', $id);
    }

    public function confirmDetail($id)
    {
        return AlertHelper::confirmInfo('detail', 'Apakah Anda yakin ingin melihat detail konsultasi pasien ini?', $id);
    }

    public function confirmInsuranceClaim($id)
    {
        return AlertHelper::confirmInfo('insuranceClaim', 'Apakah Anda yakin ingin klaim asuransi pasien ini?', $id);
    }

    public function insuranceClaim($id)
    {
        $transaction = Transaction::find($id[0]);

        if ($transaction) {
            $transaction->update([
                'is_insurance_claim' => true,
            ]);

            return AlertHelper::success('Berhasil', 'Klaim asuransi pasien '.$transaction->patient_name.' berhasil.');
        } else {
            return AlertHelper::alertError('error', 'Data tidak ditemukan');
        }
    }

    public function deleteCancel($id)
    {
        $transaction = Transaction::find($id[0]);

        if ($transaction) {
            $transaction->update([
                'status' => 'canceled',
            ]);

            return AlertHelper::success('Berhasil', 'Konsultasi pasien '.$transaction->patient_name.' berhasil dibatalkan.');
        } else {
            return AlertHelper::alertError('error', 'Data tidak ditemukan');
        }
    }

    public function callPatient($id)
    {
        $transaction = Transaction::find($id[0]);

        if ($transaction) {
            $transaction->update([
                'status' => 'call_consultation',
            ]);

            return AlertHelper::success('Berhasil', 'Pasien '.$transaction->patient_name.' berhasil dipanggil.');
        } else {
            return AlertHelper::alertError('error', 'Data tidak ditemukan');
        }
    }

    public function warning($id)
    {
        $transaction = Transaction::find($id[0]);

        if ($transaction) {
            $transaction->update([
                'status' => 'confirmation_call',
            ]);

            // $text = 'Pasien atas nama '.$transaction->patient_name.', silahkan masuk ke '.$transaction->location_name.' bertemu '.$transaction?->doctor?->name.'.';

            // $this->dispatch('callPasienAlert', $text);
        } else {
            return AlertHelper::alertError('error', 'Data tidak ditemukan');
        }
    }

    public function konsultasi($id)
    {
        $transaction = Transaction::find($id[0]);

        if ($transaction) {

            $transaction->update([
                'status' => 'consultation',
            ]);

            Session::put('transaction_id', $transaction->id);

            return redirect()->route('user.consultation.consultation.detail');
        } else {
            return AlertHelper::alertError('error', 'Data tidak ditemukan');
        }
    }

    public function detail($id)
    {
        $transaction = Transaction::find($id[0]);

        if ($transaction) {
            Session::put('transaction_id', $transaction->id);

            return redirect()->route('user.consultation.consultation.detail');
        } else {
            return AlertHelper::alertError('error', 'Data tidak ditemukan');
        }
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus konsultasi ini?', $id);
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id[0]);

        if ($transaction) {
            $transaction->delete();

            return AlertHelper::success('Berhasil', 'Konsultasi pasien '.$transaction->patient_name.' berhasil dihapus.');
        } else {
            return AlertHelper::alertError('error', 'Data tidak ditemukan');
        }
    }

    public function render()
    {
        $transactions = Transaction::search($this->search)
            ->with(['controlDoctor', 'insurance', 'doctor'])
            ->where('consultation', 'yes')
            ->where('is_insurance', true)
            // ->whereNotIn('status', ['draft_consultation', 'call_consultation', 'confirmation_call', 'consultation'])
            ->orderBy('created_at', 'desc')
            ->where('company_id', auth()->user()->company_id);

        if (Auth::user()->hasRole('Dokter')) {
            $transactions->where('doctor_id', Auth::user()->id);
        }

        if ($this->is_insurance_claim) {
            $transactions->where('is_insurance_claim', $this->is_insurance_claim);
        }

        if ($this->date) {
            $transactions = $transactions->whereDate('date', $this->date);
        }

        if ($this->location_id) {
            $transactions = $transactions->where('location_id', $this->location_id);
        }

        if ($this->insurance_id) {
            $transactions = $transactions->where('insurance_id', $this->insurance_id);
        }

        if ($this->patient_id) {
            $transactions = $transactions->where('patient_id', $this->patient_id);
        }

        return view(
            'livewire.admin.consultation.claim-insurance.admin-consultation-claim-insurance-index',
            [
                'transactions' => $transactions->paginate($this->perPage),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
}
