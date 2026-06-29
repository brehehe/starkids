<?php

namespace App\Livewire\Admin\Hr\Attendance;

use App\Models\Attendance;
use App\Models\AttendanceHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class AdminHrAttendanceIndex extends Component
{
    public $photo;

    public $latitude;

    public $longitude;

    public $address;

    public $reason;

    public function mount() {}

    public function clockIn()
    {
        $this->validateData();

        $user = auth()->user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            $this->js("alert('Anda sudah melakukan clock in hari ini.');");

            return;
        }

        // Validate Location and Time
        $company = $user->company;
        if ($company && $company->latitude && $company->longitude && $company->attendance_radius) {
            $distance = $this->calculateDistance($this->latitude, $this->longitude, $company->latitude, $company->longitude);
            if ($distance > $company->attendance_radius) {
                $this->js("alert('Anda berada di luar jangkauan area absensi perusahaan. Jarak Anda ".round($distance).'m dari batas maksimal '.$company->attendance_radius."m.');");

                return;
            }
        }

        // Define default shift status
        $status = 'present';

        if ($company && $company->work_days) {
            $workDays = json_decode($company->work_days, true);
            $currentDayName = Carbon::now()->format('l'); // example "Monday"
            if (is_array($workDays) && count($workDays) > 0 && ! in_array($currentDayName, $workDays)) {
                $this->js("alert('Hari ini bukan merupakan hari kerja Anda.');");

                return;
            }
        }

        if ($user->shift_id && $user->shift) {
            $clockInLimit = Carbon::parse($user->shift->start_time);
            if (Carbon::now()->greaterThan($clockInLimit)) {
                $status = 'late';
            }
        } elseif ($company && $company->clock_in_time) {
            $clockInLimit = Carbon::parse($company->clock_in_time);
            if (Carbon::now()->greaterThan($clockInLimit)) {
                $status = 'late';
            }
        }

        $photoPath = $this->savePhoto();

        $newAttendance = Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'clock_in_time' => Carbon::now()->format('H:i:s'),
            'clock_in_location_lat' => $this->latitude,
            'clock_in_location_long' => $this->longitude,
            'clock_in_location_address' => $this->address,
            'clock_in_photo_path' => $photoPath,
            'status' => $status,
        ]);

        AttendanceHistory::create([
            'attendance_id' => $newAttendance->id,
            'user_id' => $user->id,
            'type' => 'clock_in',
            'timestamp' => Carbon::now(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location_address' => $this->address,
            'photo_path' => $photoPath,
            'reason' => null,
        ]);

        $this->photo = null;
        $this->js("alert('Clock In berhasil!');");
    }

    public function clockOut()
    {
        $this->validateData();

        $user = auth()->user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (! $attendance) {
            $this->js("alert('Anda belum melakukan clock in hari ini.');");

            return;
        }

        if ($attendance->clock_out_time) {
            $this->js("alert('Anda sudah melakukan clock out hari ini.');");

            return;
        }

        // Validate reason for early leave if leaving early or optionally
        // We'll just always pass it if provided, but you can require it dynamically if needed.

        // Validate Location and Time
        $company = $user->company;
        if ($company && $company->latitude && $company->longitude && $company->attendance_radius) {
            $distance = $this->calculateDistance($this->latitude, $this->longitude, $company->latitude, $company->longitude);
            if ($distance > $company->attendance_radius) {
                $this->js("alert('Anda berada di luar jangkauan area absensi perusahaan. Jarak Anda ".round($distance).'m dari batas maksimal '.$company->attendance_radius."m.');");

                return;
            }
        }

        $status = $attendance->status;

        if ($user->shift_id && $user->shift) {
            $clockOutLimit = Carbon::parse($user->shift->end_time);
            if (Carbon::now()->lessThan($clockOutLimit)) {
                $status = 'left_early';
            }
        } elseif ($company && $company->clock_out_time) {
            $clockOutLimit = Carbon::parse($company->clock_out_time);
            if (Carbon::now()->lessThan($clockOutLimit)) {
                $status = 'left_early';
            }
        }

        $photoPath = $this->savePhoto();

        $attendance->update([
            'clock_out_time' => Carbon::now()->format('H:i:s'),
            'clock_out_location_lat' => $this->latitude,
            'clock_out_location_long' => $this->longitude,
            'clock_out_location_address' => $this->address,
            'clock_out_photo_path' => $photoPath,
            'status' => $status,
            'reason' => $this->reason ?: null,
        ]);

        AttendanceHistory::create([
            'attendance_id' => $attendance->id,
            'user_id' => $user->id,
            'type' => 'clock_out',
            'timestamp' => Carbon::now(),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location_address' => $this->address,
            'photo_path' => $photoPath,
            'reason' => $this->reason ?: null,
        ]);

        $this->photo = null;
        $this->js("alert('Clock Out berhasil!');");
    }

    private function validateData()
    {
        $this->validate([
            'photo' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'address' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);
    }

    private function savePhoto()
    {
        if (! $this->photo) {
            return null;
        }

        $imageParts = explode(';base64,', $this->photo);
        if (count($imageParts) < 2) {
            return null;
        }

        $imageTypeAux = explode('image/', $imageParts[0]);
        $imageType = count($imageTypeAux) > 1 ? $imageTypeAux[1] : 'png';
        $imageBase64 = base64_decode($imageParts[1]);

        $fileName = 'attendance/'.uniqid().'.'.$imageType;
        Storage::disk('public')->put($fileName, $imageBase64);

        return $fileName;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // in meters

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }

    public function render()
    {
        $user = auth()->user();
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        $historyAll = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $historyPresent = Attendance::where('user_id', $user->id)
            ->where('status', 'present')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $historyLate = Attendance::where('user_id', $user->id)
            ->where('status', 'late')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $historyLeftEarly = Attendance::where('user_id', $user->id)
            ->where('status', 'left_early')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $historyAbsent = Attendance::where('user_id', $user->id)
            ->where('status', 'absent')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $countPresent = Attendance::where('user_id', $user->id)
            ->whereDate('date', '>=', Carbon::today()->subDays(30))
            ->where('status', 'present')
            ->count();

        $countLate = Attendance::where('user_id', $user->id)
            ->whereDate('date', '>=', Carbon::today()->subDays(30))
            ->where('status', 'late')
            ->count();

        $countAbsent = Attendance::where('user_id', $user->id)
            ->whereDate('date', '>=', Carbon::today()->subDays(30))
            ->where('status', 'absent')
            ->count();

        $countLeftEarly = Attendance::where('user_id', $user->id)
            ->whereDate('date', '>=', Carbon::today()->subDays(30))
            ->where('status', 'left_early')
            ->count();

        return view('livewire.admin.hr.attendance.admin-hr-attendance-index', [
            'todayAttendance' => $todayAttendance,
            'historyAll' => $historyAll,
            'historyPresent' => $historyPresent,
            'historyLate' => $historyLate,
            'historyLeftEarly' => $historyLeftEarly,
            'historyAbsent' => $historyAbsent,
            'countPresent' => $countPresent,
            'countLate' => $countLate,
            'countAbsent' => $countAbsent,
            'countLeftEarly' => $countLeftEarly,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
