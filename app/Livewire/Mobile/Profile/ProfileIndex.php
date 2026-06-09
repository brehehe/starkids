<?php

namespace App\Livewire\Mobile\Profile;

use App\Helpers\AlertHelper;
use App\Services\Mobile\Authenticate\AuthenticateService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Milon\Barcode\Facades\DNS2DFacade;
use Throwable;

class ProfileIndex extends Component
{
    public $user;

    //data
    public $medicalRecordNumber, $qrCode;

    public function render()
    {
        return view('livewire.mobile.profile.profile-index')->layout('layout.mobile.app-mobile', [
            'activeTab'  => 'profile',
            'title' => 'Profile',
            'showHeader' => false, // login tanpa topbar
            'showBottom' => true,
        ]);
    }

    public function mount()
    {
        $this->user = Auth::user();

        $this->medicalRecordNumber = $this->user?->companyRoles()?->where('company_id', Auth::user()->company_id)?->first()?->medical_record_number ?? '-';
    }

    public function openModalLogout()
    {
        $this->dispatch('open-modal', ['id' => 'modal-logout']);
    }

    public function closeModal($id)
    {
        $this->dispatch('close-modal', ['id' => $id]);
    }

    public function showMedicalRecordNumber()
    {
        $this->qrCode = DNS2DFacade::getBarcodePNG($this->medicalRecordNumber, 'QRCODE');

        $this->dispatch('open-modal', ['id' => 'modal-rm']);
    }

    public function logout()
    {
        try {
            app(AuthenticateService::class)->logoutProcess(Auth::user()?->id);
        } catch (Exception | Throwable $th) {
            $errors = [
                'message' => $th->getMessage(),
                'file'    => $th->getFile(),
                'line'    => $th->getLine(),
            ];
            Log::error('Terjadi kesalahan saat logout', $errors);
            return AlertHelper::error("Gagal", "Terjadi kesalahan keluar aplikasi !");
        }

        return redirect()->route('mobile.login');
    }
}
