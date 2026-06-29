<?php

namespace App\Livewire\Admin\Report\Incentive;

use App\Models\User;
use App\Models\User\UserIncentive;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminReportIncentiveIndex extends Component
{
    use WithPagination;

    public $user_id;

    public $search;

    public $perPage = 5;

    public $year;

    public $month;

    public $type;

    // Array
    public $getYears = [];

    public $getMonths = [];

    public $getUsers = [];

    public function mount()
    {
        $this->year = intval(date('Y'));
        $this->month = intval(date('m'));
        $this->getYears = range(date('Y'), 2000);

        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $this->getMonths = [];

        foreach ($months as $number => $name) {
            $this->getMonths[] = [
                'number' => $number,
                'name' => $name,
            ];
        }

        $this->getUsers = User::where('company_id', Auth::user()->company_id)->where('type_user', 'employee')->select('id', 'name')->get()->toArray();
    }

    public function changeMonth($month)
    {
        $this->month = intval($month);
    }

    public function exportExcel()
    {
        $userIncentive = $this->getFilteredQuery();

        $filename = 'incentive_report_'.$this->year.'_'.sprintf('%02d', $this->month).'.xlsx';

        // Return collection for export - you'll need to implement IncentiveExport class
        return $userIncentive->get();
    }

    public function exportPDF()
    {
        $userIncentive = $this->getFilteredQuery();
        $data = [
            'userIncentives' => $userIncentive->get(),
            'statistics' => $this->getStatistics(),
            'period' => $this->getMonths[$this->month - 1]['name'].' '.$this->year,
        ];

        // Return data for PDF - you'll need to implement PDF generation
        return $data;
    }

    private function getFilteredQuery()
    {
        $userIncentive = UserIncentive::where('amount', '>', 0)->search($this->search)->with(['user:id,name', 'company:id,name']);

        if ($this->user_id) {
            $userIncentive->where('user_id', $this->user_id);
        }
        if ($this->year) {
            $userIncentive->where('year', $this->year);
        }
        if ($this->month) {
            $month = sprintf('%02d', $this->month);
            $userIncentive->where('month', $month);
        }
        if ($this->type) {
            $userIncentive->where('status', $this->type);
        }

        return $userIncentive;
    }

    private function getStatistics()
    {
        $query = $this->getFilteredQuery();

        return [
            'total_amount' => $query->sum('amount'),
            'total_records' => $query->count(),
            'average_amount' => $query->avg('amount') ?: 0,
        ];
    }

    private function getMonthlyComparison()
    {
        // Menggunakan kolom month yang bertipe string, bukan EXTRACT dari created_at
        $data = UserIncentive::where('amount', '>', 0)->selectRaw('month, SUM(amount) as total')
            ->where('year', $this->year)
            ->when(Auth::user()->company_id, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('company_id', Auth::user()->company_id);
                });
            })
            ->whereNotNull('month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $result = [];
        foreach ($data as $item) {
            // Konversi string month ke integer untuk index
            $monthNumber = intval($item->month);
            $monthIndex = $monthNumber - 1;
            if (isset($this->getMonths[$monthIndex])) {
                $result[] = [
                    'month' => $this->getMonths[$monthIndex]['name'],
                    'total' => $item->total,
                ];
            }
        }

        return $result;
    }

    private function getTopPerformers()
    {
        return UserIncentive::where('amount', '>', 0)->with('user:id,name')
            ->selectRaw('user_id, SUM(amount) as total_incentive, COUNT(*) as total_transactions')
            ->where('year', $this->year)
            ->when($this->month, function ($query) {
                $month = sprintf('%02d', $this->month);
                $query->where('month', $month);
            })
            ->when(Auth::user()->company_id, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('company_id', Auth::user()->company_id);
                });
            })
            ->groupBy('user_id')
            ->orderBy('total_incentive', 'desc')
            ->limit(5)
            ->get();
    }

    private function getStatusBreakdown()
    {
        return UserIncentive::where('amount', '>', 0)->selectRaw('status, COUNT(*) as count, SUM(amount) as total')
            ->where('year', $this->year)
            ->when($this->month, function ($query) {
                $month = sprintf('%02d', $this->month);
                $query->where('month', $month);
            })
            ->when(Auth::user()->company_id, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('company_id', Auth::user()->company_id);
                });
            })
            ->groupBy('status')
            ->get();
    }

    public function render()
    {
        $userIncentive = UserIncentive::where('amount', '>', 0)->search($this->search)->with(['user:id,name', 'company:id,name']); // Sembunyikan insentif dengan nilai 0

        if ($this->user_id) {
            $userIncentive->where('user_id', $this->user_id);
        }

        if ($this->year) {
            $userIncentive->where('year', $this->year);
        }

        if ($this->month) {
            $month = sprintf('%02d', $this->month);
            $userIncentive->where('month', $month);
        }

        if ($this->type) {
            $userIncentive->where('status', $this->type);
        }

        // Enhanced statistics
        $statistics = [
            'total_amount' => $userIncentive->sum('amount'),
            'total_records' => $userIncentive->count(),
            'average_amount' => $userIncentive->avg('amount') ?: 0,
            'monthly_comparison' => $this->getMonthlyComparison(),
            'top_performers' => $this->getTopPerformers(),
            'status_breakdown' => $this->getStatusBreakdown(),
        ];

        return view('livewire.admin.report.incentive.admin-report-incentive-index', [
            'userIncentives' => $userIncentive->paginate($this->perPage),
            'statistics' => $statistics,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
