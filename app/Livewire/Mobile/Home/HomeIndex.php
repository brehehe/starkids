<?php

namespace App\Livewire\Mobile\Home;

use App\Models\Transaction\Transaction;
use App\Services\Mobile\Doctor\DoctorService;
use App\Services\Mobile\Patient\PatientService;
use App\Services\Mobile\Polyclinic\PolyclinicService;
use App\Services\Mobile\Transaction\QueueRegisterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HomeIndex extends Component
{
    //service
    protected PatientService $patientService;
    protected QueueRegisterService $queueRegisterService;
    protected PolyclinicService $polyclinicService;
    protected DoctorService $doctorService;

    //data
    public $user;
    public $queueRegisters = [], $polyclinics = [], $doctors = [];

    public function boot(PatientService $patientService, QueueRegisterService $queueRegisterService, PolyclinicService $polyclinicService, DoctorService $doctorService)
    {
        $this->patientService       = $patientService;
        $this->queueRegisterService = $queueRegisterService;
        $this->polyclinicService    = $polyclinicService;
        $this->doctorService        = $doctorService;
    }

    public function render()
    {
        $familyMembers = $this->patientService->getFamilyMember($this->user?->id);

        $userIds = empty($familyMembers) ? [$this->user?->id] : $familyMembers?->pluck('user_id')->toArray();

        $query = [
            'status' => ['waiting_consultation', 'draft_consultation', 'call_consultation', 'confirmation_call', 'consultation']
        ];

        foreach ($this->queueRegisterService->getQueueRegisterFamilyMember($userIds, $query) ?? [] as $key => $queueRegister) {

            $currentQueueNumber = Transaction::whereDate('date', $queueRegister?->date)->where('doctor_id', $queueRegister?->doctor_id)->where('status', 'consultation')->first()?->code_consultation ?? "-------";
            $queueCount = Transaction::whereDate('date', $queueRegister?->date)->where('doctor_id', $queueRegister?->doctor_id)->count();

            $this->queueRegisters[] = [
                'id'                  => $queueRegister?->id,
                'patient_name'        => $queueRegister?->patient?->name,
                'queue_number'        => $queueRegister?->code_consultation ?? '-',
                'total_queue'         => $queueCount,
                'current_queue'       => $currentQueueNumber,
                'check_date'          => Carbon::parse($queueRegister?->date)->format('d/m/Y'),
                'doctor_status'       => 'Belum Datang',
                'doctor_status_color' => 'text-rose-500',
            ];
        }
        return view('livewire.mobile.home.home-index')->layout('layout.mobile.app-mobile', [
            'activeTab'  => 'home',
            'title'      => 'Home',
            'showHeader' => false,      // login tanpa topbar
            'showBottom' => true,
        ]);
    }

    public function mount()
    {
        $this->user = Auth::user();

        //polyclinic
        foreach ($this->polyclinicService->getPolyclinic() as $key => $getPolyclinic) {
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
                'key'   => $getPolyclinic?->id,
                'label' => $getPolyclinic?->name,
                'icon'  => $icon,
            ];
        }

        //doctor
        foreach ($this->doctorService->getDoctor() as $key => $doctor) {
            // dd($doctor?->userDetail);
            $this->doctors[] = (object)[
                'id'         => $doctor?->id,
                'profile'    => $doctor?->profile ? asset('storage/'.$doctor?->profile) : (in_array($doctor?->userDetail?->administrative_gender, ['female']) ? asset('asset/img/mobile/female-doctor.png') : asset('asset/img/mobile/male-doctor.png')) ,
                'name'       => $doctor?->name,
                'typeDoctor' => $doctor?->userDetail?->doctor_type == 'specialist' ? "Spesialis {$doctor?->userDetail?->specialization}" : "Dokter {$doctor?->userDetail?->specialization}"
            ];
        }
    }
}
