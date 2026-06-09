<?php

namespace App\Services\Mobile\Doctor;

use App\Models\Company\Company;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Models\User\ControlDoctor;
use Carbon\Carbon;

class DoctorService
{
    /**
     * Create a new class instance.
     */

    public $company;
    public function __construct()
    {
        //
        $this->company = Company::where('code', config('app.company_code'))->first();
    }

    public function getDoctorSchedule($location_id, $date)
    {

        if ($location_id && $date) {
           $days = [
                'Sunday'    => 'Minggu',
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu',
            ];

            $englishDay = Carbon::parse($date)->englishDayOfWeek;
            $days = $days[$englishDay] ?? null;

            // Ambil semua control doctor (jadwal dokter) sesuai lokasi + hari
            $controlDoctorRows = ControlDoctor::query()
                ->with(['user:id,name']) // ganti ke relasi dokter kamu jika bukan "user"
                ->where('location_id', $location_id)
                ->where(function ($query) use ($days) {
                    $query->whereJsonContains('days', $days)
                        ->orWhere('is_unlimited', true);
                })
                ->orderBy('start_time')
                ->get();

            // Hitung transaksi per control_doctor_id untuk tanggal tsb (sekali query, lebih cepat)
            $transactionCounts = Transaction::query()
                ->selectRaw('control_doctor_id, COUNT(*) as total')
                ->where('location_id', $location_id)
                ->whereDate('date', $date)
                ->whereIn('control_doctor_id', $controlDoctorRows->pluck('id'))
                ->groupBy('control_doctor_id')
                ->pluck('total', 'control_doctor_id'); // [control_doctor_id => total]

            return $controlDoctorRows->filter(function ($item) use ($transactionCounts) {
                    // dokter unlimited tetap tampil
                    if ($item->is_unlimited) {
                        return true;
                    }

                    $count = (int) ($transactionCounts[$item->id] ?? 0);

                    return $count < (int) $item->max_patients;
                })
                ->map(function ($item) use ($transactionCounts, $days, $date) {
                    $countTransactions = (int) ($transactionCounts[$item->id] ?? 0);

                    $maxPatients = $item->is_unlimited ? null : (int) $item->max_patients;
                    $remainingQuota = $item->is_unlimited ? null : max(0, ((int) $item->max_patients - $countTransactions));
                    $isFull = $item->is_unlimited ? false : ($countTransactions >= (int) $item->max_patients);

                    return (object)[
                        // jadwal / control
                        'id' => $item->id, // id control_doctor (jadwal)
                        'days' => $days,
                        'date' => $date,
                        'start_time' => $item->start_time?->format('H:i'),
                        'end_time' => $item->end_time?->format('H:i'),

                        // dokter
                        'doctor_id' => $item->user_id,
                        'doctor_name' => $item->user?->name ?? '-',
                        'specialization' => $item?->user?->roleDoctor?->specialization ?? '',

                        // quota
                        'max_patients' => $maxPatients,
                        'current_patients' => $countTransactions,
                        'remaining_quota' => $remainingQuota,
                        'is_full' => $isFull,
                        'is_unlimited' => (bool) $item->is_unlimited,
                    ];
                })
                ->values()
                ->toArray();

        } else {
            return [];
        }
    }

    public function getDoctor()
    {
        return User::role('Dokter')
            ->where('company_id', $this->company?->id)
            ->where('type_user', 'employee')
            ->orderBy('name', 'asc')->get();
    }
}
