<?php

namespace App\Livewire\Mobile\QueueRegister;

use App\Helpers\AlertHelper;
use App\Models\Family\Family;
use App\Models\User;
use App\Services\Mobile\Doctor\DoctorService;
use App\Services\Mobile\Patient\PatientService;
use App\Services\Mobile\Polyclinic\PolyclinicService;
use App\Services\Mobile\Transaction\QueueRegisterService;
use App\Traits\Company\CompanyTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Throwable;

class QueueRegisterIndex extends Component
{
    use CompanyTrait;

    // service
    protected DoctorService $doctorService;

    protected QueueRegisterService $queueRegisterService;

    // array
    public $patients = [];

    public $dates = [];

    public $polyclinics = [];

    public $doctorSchedules = [];

    // data mount
    public $user;

    public $family;

    // data
    public ?string $selectedPatientId = null;

    public ?string $selectedPolyclinic = null;

    public $selectedDateKey;

    public ?string $selectedScheduleId = null;

    // conditions
    public ?bool $buttonCreate = false;

    public function render()
    {
        return view('livewire.mobile.queue-register.queue-register-index')->layout('layout.mobile.app-mobile', [
            'activeTab' => 'queue-register',
            'title' => 'Queue',
            'showHeader' => false,     // login tanpa topbar
            'showBottom' => true,
        ]);
    }

    public function mount(PatientService $patientService, PolyclinicService $polyclinicService): void
    {
        // list user/ family user
        $this->user = Auth::user();

        $this->patients = [];
        $getFamilyMember = $patientService->getFamilyMember($this->user?->id);

        if (! empty($getFamilyMember)) {
            foreach ($getFamilyMember as $key => $member) {
                $user = User::find($member?->user_id);
                $this->patients[] = [
                    'id' => $user?->id,
                    'name' => $user?->name,
                    'rm' => $user?->companyRoles?->first()?->medical_record_number ?? '-',
                    'tag' => ucfirst(Str::title(Str::replace('_', ' ', $member->relationship))),
                    'tagClass' => 'bg-pink-100 text-pink-600',
                    'avatar' => in_array($member->relationship, ['kepala_keluarga', 'suami', 'ayah', 'kakek', 'anak']) ? asset('asset/img/mobile/male-profile.png') : asset('asset/img/mobile/female-profile.png'),
                ];
            }
        } else {
            $getPatient = $patientService->getPatient($this->user?->id);
            $user = User::find($getPatient?->id);
            $this->patients[] = [
                'id' => $getPatient?->id,
                'name' => $getPatient?->name,
                'rm' => $user?->companyRoles?->first()?->medical_record_number ?? '-',
                'tag' => '-',
                'tagClass' => 'bg-pink-100 text-pink-600',
                'avatar' => asset('asset/img/mobile/male-profile.png'),
            ];

            $this->selectedPatientId = $getPatient?->id;
        }

        // dates
        $start = now(); // atau Carbon::today()
        $this->dates = collect(range(0, 13)) // 2 minggu contoh
            ->map(function ($i) use ($start) {
                $date = $start->copy()->addDays($i);

                return [
                    'key' => $date->format('Y-m-d'),
                    'date' => $date->format('Y-m-d'),
                    'dow' => $date->isoFormat('ddd'),  // Sen, Sel, Rab...
                    'day' => $date->format('d'),
                    'month' => $date->isoFormat('MMM'), // Jan, Feb...
                    'is_today' => $date->isToday(),
                ];
            })
            ->toArray();

        $this->selectedDateKey ??= now()->format('Y-m-d');

        // polyclinic
        $getPolyclinic = $polyclinicService->getPolyclinic();

        foreach ($getPolyclinic as $key => $getPolyclinic) {
            if ($getPolyclinic?->slug == 'instalasi-farmasi') {
                $icon = asset('asset/img/mobile/icon/farmasi.png');
            } elseif ($getPolyclinic?->slug == 'poli-anak') {
                $icon = asset('asset/img/mobile/icon/anak.png');
            } elseif ($getPolyclinic?->slug == 'poli-gigi') {
                $icon = asset('asset/img/mobile/icon/gigi.png');
            } elseif ($getPolyclinic?->slug == 'poli-kulit-dan-kelamin') {
                $icon = asset('asset/img/mobile/icon/kulit.png');
            } elseif ($getPolyclinic?->slug == 'poli-umum') {
                $icon = asset('asset/img/mobile/icon/umum.png');
            } else {
                $icon = asset('asset/img/mobile/icon/default.png');
            }
            $this->polyclinics[] = [
                'key' => $getPolyclinic?->id,
                'label' => $getPolyclinic?->name,
                'icon' => $icon,      // plus icon (contoh path)
            ];
        }
    }

    public function boot(DoctorService $doctorService, QueueRegisterService $queueRegisterService): void
    {
        $this->doctorService = $doctorService;
        $this->queueRegisterService = $queueRegisterService;
    }

    public function selectPatient($id): void
    {
        $this->selectedPatientId = $id;
        $this->getDoctorSchedule();
    }

    public function selectDate(string $key): void
    {
        $this->selectedDateKey = $key;
        $this->getDoctorSchedule();
    }

    public function selectPolyclinic(string $key): void
    {
        $this->selectedPolyclinic = $key;
        $this->getDoctorSchedule();
    }

    public function selectSchedule(string $id): void
    {
        $this->selectedScheduleId = $id;
        if ($this->selectedScheduleId != null) {
            $this->buttonCreate = true;
        }
    }

    public function getDoctorSchedule()
    {
        $this->selectedScheduleId = null;
        $this->buttonCreate = false;
        if ($this->selectedPatientId != null && $this->selectedDateKey != null && $this->selectedPolyclinic != null) {
            // doctor schedules
            $getDoctorSchedules = $this->doctorService->getDoctorSchedule($this->selectedPolyclinic, $this->selectedDateKey);

            $this->doctorSchedules = [];
            foreach ($getDoctorSchedules as $key => $getDoctorSchedule) {
                $this->doctorSchedules[] = [
                    'id' => $getDoctorSchedule?->id,
                    'doctor' => $getDoctorSchedule?->doctor_name,
                    'desc' => $getDoctorSchedule?->specialization,
                    'time' => "{$getDoctorSchedule?->start_time} WIB - {$getDoctorSchedule?->end_time} WIB",
                    'avatar' => asset('asset/img/mobile/doctor-image.jpeg'),
                    'selected' => false,
                ];
            }
        }
    }

    public function openModal()
    {
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function submit()
    {
        $this->closeModal();
        try {
            // code...
            // doctor_id
            $getDoctorSchedules = $this->doctorService->getDoctorSchedule($this->selectedPolyclinic, $this->selectedDateKey);
            $doctorId = collect($getDoctorSchedules)->where('id', $this->selectedScheduleId)->first()?->doctor_id;

            DB::beginTransaction();
            $createQueue = $this->queueRegisterService->createQueue($this->selectedPolyclinic, $doctorId, $this->selectedPatientId, $this->selectedDateKey, $this->selectedScheduleId);
            DB::commit();
        } catch (Exception|Throwable $th) {
            DB::rollBack();
            $errors = [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ];
            Log::error('Ada kesalahan (QueueRegisterService => createQueue)', $errors);

            return AlertHelper::error('Gagal', 'Ada kesalahan saat mendaftar antrian');
        }

        return redirect()->route('mobile.queue.register.detail', $createQueue?->id);
    }
}
