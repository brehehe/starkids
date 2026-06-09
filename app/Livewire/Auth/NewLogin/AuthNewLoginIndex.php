<?php

namespace App\Livewire\Auth\NewLogin;

use App\Helpers\AlertHelper;
use App\Models\Company\Company;
use App\Models\SystemUpdate\SystemUpdate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Computed;

class AuthNewLoginIndex extends Component
{
    public $code;
    public $captchaCode;
    public $captchaInput;
    public $username_or_email;
    public $password;
    public $remember = false;

    public function mount()
    {
        if (Auth::check()) {
            return $this->redirect(route('admin.dashboard'));
        }

        $this->generateCaptcha();

        // Default values for simplified login (hidden in UI)
        $this->code = 'Strkds';
        $this->captchaInput = $this->captchaCode;

        if (config('app.env') === 'local' || config('app.env') === 'development') {
            $this->username_or_email = 'starkidsmedicalcenter';
            $this->password = 12345678;
        }
    }

    #[Computed]
    public function systemUpdates()
    {
        return SystemUpdate::active()
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
    }

    public function generateCaptcha()
    {
        $this->captchaCode = collect(str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'))
            ->shuffle()
            ->take(6)
            ->implode('');
    }

    public function rules()
    {
        return [
            'code' => 'required',
            'username_or_email' => 'required',
            'password' => 'required',
            'captchaInput' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value !== $this->captchaCode) {
                        $fail('Kode captcha tidak sesuai.');
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode wajib diisi.',
            'username_or_email.required' => 'Username atau email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'captchaInput.required' => 'Captcha wajib diisi.',
        ];
    }

    public function login()
    {
        $this->validate();

        $company = Company::where('code', $this->code)->first();
        if (!$company) {
            $this->showAlert('Kode perusahaan tidak ditemukan');
            return;
        }

        $userResult = $this->findUserWithIdentityResolution($company->id);

        if (!$userResult['success']) {
            return AlertHelper::error('Akses Ditolak', $userResult['message']);
        }

        $user = $userResult['user'];
        $loginMethod = $userResult['login_method'];

        if ($user->type_user !== 'employee') {
            return AlertHelper::error('Akses Ditolak', 'Hanya karyawan yang dapat mengakses sistem ini.');
        }

        $userRoleCompany = $user->companyRoles()->where('company_id', $company->id)->first();

        if (!$userRoleCompany) {
            return AlertHelper::error('Akses Ditolak', 'Anda tidak memiliki akses ke perusahaan ini.');
        }

        if (!$userRoleCompany->is_active) {
            return AlertHelper::error('Akses Ditolak', 'Akun Anda sedang tidak aktif.');
        }

        $loginField = $this->determineLoginField($loginMethod);
        $loginValue = $this->getLoginValue($user, $loginMethod);

        $credentials = [
            $loginField => $loginValue,
            'password' => $this->password,
            'type_user' => 'employee',
        ];

        if (auth()->attempt($credentials, $this->remember)) {
            $user = User::find(auth()->user()->id);
            $user->company_id = $company->id;
            $user->save();

            $this->storeLoginContext($user, $company, $loginMethod);

            session()->flash('saved', [
                'title' => 'Login Berhasil!',
                'text' => 'Anda berhasil login ke sistem!',
            ]);

            return $this->redirect(route('user.dashboard'));
        }

        $this->showAlert('Email, username, atau password salah');
    }

    protected function findUserWithIdentityResolution($companyId)
    {
        $identifier = $this->username_or_email;

        $mainUser = $this->findByMainFields($identifier, $companyId);
        if ($mainUser) {
            return [
                'success' => true,
                'user' => $mainUser['user'],
                'login_method' => $mainUser['method'],
                'message' => 'Found via main fields'
            ];
        }

        $altUser = $this->findByAlternativeContacts($identifier, $companyId);
        if ($altUser) {
            return [
                'success' => true,
                'user' => $altUser['user'],
                'login_method' => $altUser['method'],
                'message' => 'Found via alternative contacts'
            ];
        }

        return [
            'success' => false,
            'user' => null,
            'login_method' => null,
            'message' => 'Username atau email tidak ditemukan.'
        ];
    }

    protected function findByMainFields($identifier, $companyId)
    {
        $users = User::where('type_user', 'employee')
            ->where(function ($query) use ($identifier) {
                $query->where('username', $identifier)
                    ->orWhere('email', $identifier)
                    ->orWhere('phone', $identifier);
            })->get();

        foreach ($users as $user) {
            if ($user->companyRoles()->where('company_id', $companyId)->where('is_active', true)->exists()) {
                $method = $this->determineMatchedField($user, $identifier);
                return [
                    'user' => $user,
                    'method' => $method
                ];
            }
        }

        return null;
    }

    protected function findByAlternativeContacts($identifier, $companyId)
    {
        $users = User::where('type_user', 'employee')
            ->whereJsonContains('alternative_contacts', function ($contact) use ($identifier, $companyId) {
                return ($contact['value'] === $identifier && $contact['context'] == $companyId);
            })->get();

        foreach ($users as $user) {
            if ($user->companyRoles()->where('company_id', $companyId)->where('is_active', true)->exists()) {
                $contacts = $user->alternative_contacts ?? [];
                $contactType = null;

                foreach ($contacts as $contact) {
                    if ($contact['value'] === $identifier && $contact['context'] == $companyId) {
                        $contactType = $contact['type'];
                        break;
                    }
                }

                return [
                    'user' => $user,
                    'method' => 'alternative_' . $contactType
                ];
            }
        }

        return null;
    }

    protected function determineMatchedField($user, $identifier)
    {
        if ($user->email === $identifier) {
            return 'email';
        } elseif ($user->username === $identifier) {
            return 'username';
        } elseif ($user->phone === $identifier) {
            return 'phone';
        }

        return 'unknown';
    }

    protected function determineLoginField($loginMethod)
    {
        switch ($loginMethod) {
            case 'email':
            case 'alternative_email':
                return 'email';
            case 'username':
                return 'username';
            case 'phone':
            case 'alternative_phone':
                return 'phone';
            default:
                return filter_var($this->username_or_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        }
    }

    protected function getLoginValue($user, $loginMethod)
    {
        switch ($loginMethod) {
            case 'email':
                return $user->email;
            case 'username':
                return $user->username;
            case 'phone':
                return $user->phone;
            case 'alternative_email':
            case 'alternative_phone':
                return $this->mapAlternativeToMainField($user, $loginMethod);
            default:
                return $this->username_or_email;
        }
    }

    protected function mapAlternativeToMainField($user, $loginMethod)
    {
        switch ($loginMethod) {
            case 'alternative_email':
                return $user->email;
            case 'alternative_phone':
                return $user->phone;
            default:
                return $user->email;
        }
    }

    protected function storeLoginContext($user, $company, $loginMethod)
    {
        session([
            'current_company_id' => $company->id,
            'current_company' => $company,
            'login_method' => $loginMethod,
            'login_identifier' => $this->username_or_email,
            'login_timestamp' => now(),
            'user_type' => $user->type_user,
        ]);

        $user->update(['last_login_at' => now()]);
    }

    protected function showAlert($message)
    {
        LivewireAlert::title('Gagal')
            ->text($message)
            ->error()
            ->position('top-end')
            ->toast()
            ->timer(2000)
            ->show();
    }

    public function render()
    {
        return view('livewire.auth.new-login.auth-new-login-index')
            ->extends('layout.auth.app')
            ->section('content');
    }
}
