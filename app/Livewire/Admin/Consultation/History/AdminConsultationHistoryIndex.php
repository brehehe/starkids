<?php

namespace App\Livewire\Admin\Consultation\History;

use App\Helpers\AlertHelper;
use App\Models\Location\Location;
use App\Models\Transaction\Transaction;
use Livewire\Component;
use Livewire\WithPagination;
use Session;
use Illuminate\Support\Facades\Auth;

class AdminConsultationHistoryIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $perPage = 5;
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $location_id;
    public $locations = [];

    public function mount()
    {
        $this->start_date = '';
        $this->end_date = '';
        $this->locations = Location::where('company_id', auth()->user()->company_id)->select('id', 'name')->get()->pluck('name', 'id')->toArray();

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

    public function deleteCancel($id)
    {
        $transaction = Transaction::find($id[0]);

        if ($transaction) {
            $transaction->update([
                'status' => 'canceled',
            ]);

            return AlertHelper::success('Berhasil', 'Konsultasi pasien ' . $transaction->patient_name . ' berhasil dibatalkan.');
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

            return AlertHelper::success('Berhasil', 'Pasien ' . $transaction->patient_name . ' berhasil dipanggil.');
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

            return AlertHelper::success('Berhasil', 'Konsultasi pasien ' . $transaction->patient_name . ' berhasil dihapus.');
        } else {
            return AlertHelper::alertError('error', 'Data tidak ditemukan');
        }
    }

    public function render()
    {
        $transactions = Transaction::search($this->search)
            ->where('consultation', 'yes')
            // ->whereNotIn('status', ['draft_consultation', 'call_consultation', 'confirmation_call', 'consultation'])
            ->orderBy('created_at', 'desc')
            ->where('company_id', auth()->user()->company_id);

        if (Auth::user()->hasRole('Dokter')) {
            $transactions->where('doctor_id', Auth::user()->id);
        }

        if ($this->start_date) {
            $transactions->whereDate('date', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $transactions->whereDate('date', '<=', $this->end_date);
        }

        if ($this->start_time) {
            $transactions->whereTime('created_at', '>=', $this->start_time);
        }

        if ($this->end_time) {
            $transactions->whereTime('created_at', '<=', $this->end_time);
        }

        if ($this->location_id) {
            $transactions->where('location_id', $this->location_id);
        }

        return view(
            'livewire.admin.consultation.history.admin-consultation-history-index',
            [
                'transactions' => $transactions->paginate($this->perPage),
                'peakHours' => $this->getPeakHours(),
                'statusStats' => $this->getStatusStats(),
            ]
        )
            ->extends('layout.app')
            ->section('content');
    }
    public function getPeakHours()
    {
        $query = Transaction::query()
            ->where('consultation', 'yes')
            ->where('company_id', auth()->user()->company_id);

        if (Auth::user()->hasRole('Dokter')) {
            $query->where('doctor_id', Auth::user()->id);
        }

        if ($this->start_date) {
            $query->whereDate('date', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('date', '<=', $this->end_date);
        }

        if ($this->location_id) {
            $query->where('location_id', $this->location_id);
        }

        if ($this->start_time) {
            $query->whereTime('created_at', '>=', $this->start_time);
        }

        if ($this->end_time) {
            $query->whereTime('created_at', '<=', $this->end_time);
        }

        return $query->select('created_at')
            ->get()
            ->groupBy(function ($date) {
                return \Carbon\Carbon::parse($date->created_at)->format('H:00');
            })
            ->map(function ($item) {
                return $item->count();
            })
            ->sortDesc();
    }

    public function getStatusStats()
    {
        $query = Transaction::query()
            ->where('consultation', 'yes')
            ->where('company_id', auth()->user()->company_id);

        if (Auth::user()->hasRole('Dokter')) {
            $query->where('doctor_id', Auth::user()->id);
        }

        if ($this->start_date) {
            $query->whereDate('date', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $query->whereDate('date', '<=', $this->end_date);
        }

        if ($this->location_id) {
            $query->where('location_id', $this->location_id);
        }

        if ($this->start_time) {
            $query->whereTime('created_at', '>=', $this->start_time);
        }

        if ($this->end_time) {
            $query->whereTime('created_at', '<=', $this->end_time);
        }

        // We can optimize this to a single query with aggregates if needed,
        // but for now let's clone the query for simplicity and readability or use selectRaw.
        // selectRaw is better.

        $stats = $query->selectRaw("
            count(*) as total,
            sum(case when status not in ('completed', 'canceled') then 1 else 0 end) as process,
            sum(case when status = 'completed' then 1 else 0 end) as completed,
            sum(case when status = 'canceled' then 1 else 0 end) as canceled
        ")->first();

        return [
            'total' => $stats->total ?? 0,
            'process' => $stats->process ?? 0,
            'completed' => $stats->completed ?? 0,
            'canceled' => $stats->canceled ?? 0,
        ];
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'start_date',
            'end_date',
            'start_time',
            'end_time',
            'location_id',
        ]);
    }
}
