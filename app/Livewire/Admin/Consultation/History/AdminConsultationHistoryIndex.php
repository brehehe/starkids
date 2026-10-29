<?php

namespace App\Livewire\Admin\Consultation\History;

use App\Helpers\AlertHelper;
use App\Models\Location\Location;
use App\Models\Transaction\Transaction;
use App\Traits\Report\HasReportExportTrait;
use App\Traits\Transaction\ReversesTransactionStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Session;

class AdminConsultationHistoryIndex extends Component
{
    use HasReportExportTrait;
    use ReversesTransactionStock;
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
            $this->reverseStockForTransaction($transaction);

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

    protected function getFilteredQuery()
    {
        $transactions = Transaction::search($this->search)
            ->with(['patient.userDetail', 'patient.patient.OHPatient', 'doctor', 'controlDoctor'])
            ->where('consultation', 'yes')
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

        return $transactions;
    }

    public function exportExcel()
    {
        $statusLabels = [
            'waiting_consultation' => 'Menunggu Konsultasi',
            'draft_consultation' => 'Draft Konsultasi',
            'call_consultation' => 'Panggil Konsultasi',
            'confirmation_call' => 'Konfirmasi Panggilan',
            'consultation' => 'Konsultasi',
            'pharmacy' => 'Farmasi',
            'call_pharmacy' => 'Panggil Farmasi',
            'sale_pharmacy' => 'Penjualan Farmasi',
            'draft' => 'Draft',
            'process' => 'Proses',
            'take_medicine' => 'Pengambilan Obat',
            'completed' => 'Selesai',
            'canceled' => 'Dibatalkan',
        ];

        $items = $this->getFilteredQuery()->get();
        $headings = ['No', 'No. Antrian', 'Tgl Daftar', 'Asuransi', 'Pasien', 'No. IHS', 'No. HP', 'Dokter', 'Poli', 'Status'];
        $rows = [];

        foreach ($items as $idx => $t) {
            $ihs = $t->patient?->patient?->OHPatient?->id_patient
                ?? $t->patient?->patient?->ihs_number
                ?? $t->patient?->userDetail?->ihs_number
                ?? '-';

            $rows[] = [
                $idx + 1,
                $t->code_consultation ?? '-',
                $t->created_at ? Carbon::parse($t->created_at)->locale('id')->isoFormat('D MMMM Y HH:mm') : '-',
                $t->is_insurance ? 'Ya' : 'Tidak',
                $t->patient_name ?? '-',
                $ihs,
                $t->patient?->phone ?? '-',
                $t->doctor?->name ?? '-',
                $t->location_name ?? '-',
                $statusLabels[$t->status] ?? $t->status,
            ];
        }

        return $this->exportExcelResponse('history_konsultasi', $headings, $rows, 'Konsultasi');
    }

    public function exportPDF()
    {
        $statusLabels = [
            'waiting_consultation' => 'Menunggu Konsultasi',
            'draft_consultation' => 'Draft Konsultasi',
            'call_consultation' => 'Panggil Konsultasi',
            'confirmation_call' => 'Konfirmasi Panggilan',
            'consultation' => 'Konsultasi',
            'pharmacy' => 'Farmasi',
            'call_pharmacy' => 'Panggil Farmasi',
            'sale_pharmacy' => 'Penjualan Farmasi',
            'draft' => 'Draft',
            'process' => 'Proses',
            'take_medicine' => 'Pengambilan Obat',
            'completed' => 'Selesai',
            'canceled' => 'Dibatalkan',
        ];

        $items = $this->getFilteredQuery()->get();
        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '25px'],
            ['label' => 'No. Antrian', 'align' => 'center', 'width' => '75px'],
            ['label' => 'Tgl Daftar', 'align' => 'center', 'width' => '95px'],
            ['label' => 'Asuransi', 'align' => 'center', 'width' => '45px'],
            ['label' => 'Pasien', 'align' => 'left'],
            ['label' => 'No. IHS', 'align' => 'center', 'width' => '75px'],
            ['label' => 'No. HP', 'align' => 'center', 'width' => '75px'],
            ['label' => 'Dokter', 'align' => 'left', 'width' => '85px'],
            ['label' => 'Poli', 'align' => 'left', 'width' => '75px'],
            ['label' => 'Status', 'align' => 'center', 'width' => '75px'],
        ];
        $rows = [];

        foreach ($items as $idx => $t) {
            $ihs = $t->patient?->patient?->OHPatient?->id_patient
                ?? $t->patient?->patient?->ihs_number
                ?? $t->patient?->userDetail?->ihs_number
                ?? '-';

            $rows[] = [
                $idx + 1,
                $t->code_consultation ?? '-',
                $t->created_at ? Carbon::parse($t->created_at)->locale('id')->isoFormat('D MMMM Y HH:mm') : '-',
                $t->is_insurance ? 'Ya' : 'Tidak',
                $t->patient_name ?? '-',
                $ihs,
                $t->patient?->phone ?? '-',
                $t->doctor?->name ?? '-',
                $t->location_name ?? '-',
                $statusLabels[$t->status] ?? $t->status,
            ];
        }

        $period = ($this->start_date || $this->end_date)
            ? (($this->start_date ?: 'Awal').' s/d '.($this->end_date ?: 'Sekarang'))
            : null;

        return $this->exportPDFResponse('history_konsultasi', 'History Konsultasi Pasien', $columns, $rows, 'landscape', null, $period);
    }

    public function render()
    {
        $transactions = $this->getFilteredQuery();

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
                return Carbon::parse($date->created_at)->format('H:00');
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
