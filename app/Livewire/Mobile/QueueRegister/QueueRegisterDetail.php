<?php

namespace App\Livewire\Mobile\QueueRegister;

use App\Models\Transaction\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class QueueRegisterDetail extends Component
{
    public string $doctorName = 'dr. Sugiarto Syamsudin';
    public string $doctorAvatar = '/images/doctor-1.jpg';

    public $currentQueueNumber = 'DM007';
    public int|string $queueCount = '015';
    public string $checkupDate = '24 / 11 / 2022';
    public string $doctorStatus = 'Sudah Datang';

    public ?string $yourQueueNumber = 'DM016';
    public string $clinicLabel = 'Praktek Dokter Mata';


    public $transaction, $selectedDateLabel, $selectedPoliName, $selectedDoctorSchedule;

    public function render()
    {
        return view('livewire.mobile.queue-register.queue-register-detail')->layout('layout.mobile.app-mobile', [
            'activeTab'  => 'queue-register-detail',
            'title'      => 'Queue Register Detail',
            'showHeader' => false,              // login tanpa topbar
            'showBottom' => false,
        ]);
    }

    public function mount($id)
    {
        $this->transaction            = Transaction::find($id);
        $this->doctorName             = $this->transaction?->doctor_name;
        $this->doctorAvatar           = asset('asset/img/mobile/doctor-image.jpeg');
        $this->yourQueueNumber        = $this->transaction?->code_consultation;
        $this->clinicLabel            = $this->transaction?->location_name;
        $this->selectedDateLabel      = Carbon::parse($this->transaction?->date)->format('d M Y');
        $this->selectedPoliName       = $this->transaction?->location_name;
        $this->selectedDoctorSchedule = $this->transaction?->controlDoctor?->start_time_get ." - ". $this->transaction?->controlDoctor?->end_time_get ;

        $this->checkupDate = Carbon::now()->format('d M Y');
        $this->currentQueueNumber = Transaction::whereDate('date', now()->toDateString())->where('doctor_id', $this->transaction?->doctor_id)->where('status', 'consultation')->first()?->code_consultation ?? "-------";
        $this->queueCount = Transaction::whereDate('date', now()->toDateString())->where('doctor_id', $this->transaction?->doctor_id)->count();
    }

    public function back()
    {
        return redirect()->back();
    }

    public function takeQueue()
    {
        // TODO: panggil service / repository buat generate nomor antrian
        // contoh:
        // $this->yourQueueNumber = $this->queueService->take($this->doctorId, $this->date);

        // sementara demo:
        $this->yourQueueNumber = $this->yourQueueNumber ?? 'DM016';
    }
}
