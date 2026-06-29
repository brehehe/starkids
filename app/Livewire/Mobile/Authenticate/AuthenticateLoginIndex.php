<?php

namespace App\Livewire\Mobile\Authenticate;

use App\Helpers\AlertHelper;
use App\Services\Mobile\Authenticate\AuthenticateService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class AuthenticateLoginIndex extends Component
{
    public $contect;

    public $password;

    public function render()
    {
        return view('livewire.mobile.authenticate.authenticate-login-index')->layout('layout.mobile.app-mobile', [
            'title' => 'Masuk',
            'showHeader' => false, // login tanpa topbar
            'showBottom' => false,
        ]);
    }

    public function mount()
    {
        $this->contect = 'PMR25090300118';
        if (Auth::check()) {
            return redirect()->route('mobile.home');
        }
    }

    public function login()
    {

        $this->validate(
            [
                'contect' => 'required',
                'password' => 'required',
            ],
            [
                'contect.required' => 'Email atau No. RM wajib diisi',
                'password.required' => 'Kata sandi wajib diisi',
            ]
        );

        try {
            $request = [
                'contect' => $this->contect,
                'password' => $this->password,
                'remember' => true,
            ];

            app(AuthenticateService::class)->loginProsses($request);

        } catch (Exception|Throwable $th) {
            $this->reset(['password']);
            $errors = [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ];

            Log::error('Ada kesalahan saat login mobile', $errors);

            return AlertHelper::warning(
                'Pemberitahuan',
                'Email, No.RM, atau password tidak valid !'
            );
        }

        return redirect()->route('mobile.home');
    }
}
