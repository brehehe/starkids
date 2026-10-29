<?php

namespace App\Livewire\Admin\Report\Odontogram;

use App\Models\Transaction\TransactionDetail;
use App\Models\User;
use App\Traits\Report\HasReportExportTrait;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportOdontogramIndex extends Component
{
    use HasReportExportTrait, WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'patient_id' => ['except' => ''],
    ];

    public $patient_id;

    public $patients = [];

    public $odontogram_map = [];

    public $frequent_odontogram = null;

    public $perPage = 5;

    public function mount()
    {
        $this->patients = User::role('Pasien')
            ->where('company_id', auth()->user()->company_id)
            ->orderBy('name', 'asc')
            ->get();

        if ($this->patient_id) {
            $this->loadOdontogramData();
        }
    }

    public function updatedPatientId()
    {
        $this->resetPage();
        if ($this->patient_id) {
            $this->loadOdontogramData();
        } else {
            $this->reset(['odontogram_map', 'frequent_odontogram']);
        }
    }

    public function loadOdontogramData()
    {
        if (! $this->patient_id) {
            return;
        }

        // 1. Load Map (Current State)
        $details = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->patient_id);
        })
            ->whereNotNull('odontogram_code')
            ->orderBy('created_at', 'asc') // Replay history to get final state
            ->get();

        $this->odontogram_map = [];
        foreach ($details as $detail) {
            if ($detail->odontogram_code) {
                $this->odontogram_map[$detail->odontogram_code] = $detail->odontogram_color ?? '#3b82f6';
            }
        }

        // 2. Load Most Frequent
        $frequent = TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->patient_id);
        })
            ->whereNotNull('odontogram_code')
            ->select('odontogram_code', \DB::raw('count(*) as total'))
            ->groupBy('odontogram_code')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $this->frequent_odontogram = $frequent;
    }

    public function render()
    {
        return view('livewire.admin.report.odontogram.admin-report-odontogram-index', [
            'historyOdontograms' => $this->getHistoryOdontograms(),
        ])
            ->extends('layout.app')
            ->section('content');
    }

    public function getHistoryOdontogramsQuery()
    {
        if (! $this->patient_id) {
            return TransactionDetail::whereRaw('1 = 0');
        }

        return TransactionDetail::whereHas('transaction', function ($query) {
            $query->where('patient_id', $this->patient_id);
        })
            ->whereNotNull('odontogram_code')
            ->with(['transaction.doctor', 'product'])
            ->orderBy('created_at', 'desc');
    }

    public function exportExcel()
    {
        $patient = $this->patient_id ? User::find($this->patient_id) : null;
        $items = $this->getHistoryOdontogramsQuery()->get();

        $headings = ['No', 'Tanggal', 'Dokter', 'Kode Gigi', 'Kondisi / Tindakan', 'Keterangan'];
        $rows = [];

        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-',
                $item->transaction->doctor->name ?? '-',
                $item->odontogram_code ?? '-',
                $item->product->name ?? ($item->name ?? '-'),
                $item->description ?? '-',
            ];
        }

        $filename = 'laporan_odontogram_'.($patient ? str_replace(' ', '_', $patient->name) : 'semua');

        return $this->exportExcelResponse($filename, $headings, $rows, 'Odontogram');
    }

    public function exportPDF()
    {
        $patient = $this->patient_id ? User::find($this->patient_id) : null;
        $items = $this->getHistoryOdontogramsQuery()->get();

        $columns = [
            ['label' => 'No', 'align' => 'center', 'width' => '30px'],
            ['label' => 'Tanggal', 'align' => 'center', 'width' => '90px'],
            ['label' => 'Dokter', 'align' => 'left', 'width' => '110px'],
            ['label' => 'Kode Gigi', 'align' => 'center', 'width' => '65px'],
            ['label' => 'Kondisi / Tindakan', 'align' => 'left'],
            ['label' => 'Keterangan', 'align' => 'left'],
        ];

        $rows = [];
        foreach ($items as $idx => $item) {
            $rows[] = [
                $idx + 1,
                $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-',
                e($item->transaction->doctor->name ?? '-'),
                e($item->odontogram_code ?? '-'),
                e($item->product->name ?? ($item->name ?? '-')),
                e($item->description ?? '-'),
            ];
        }

        $period = $patient ? 'Pasien: '.$patient->name.' ('.$patient->phone.')' : 'Semua Pasien';
        $filename = 'laporan_odontogram_'.($patient ? str_replace(' ', '_', $patient->name) : 'semua');

        return $this->exportPDFResponse($filename, 'Laporan Odontogram Gigi', $columns, $rows, 'portrait', null, $period);
    }

    public function getHistoryOdontograms()
    {
        if (! $this->patient_id) {
            return collect();
        }

        return $this->getHistoryOdontogramsQuery()->paginate($this->perPage);
    }
}
