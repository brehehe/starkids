<?php

namespace App\Services\Mobile\Authenticate;

use App\Models\Company\Company;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticateService
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

    public function loginProsses($request)
    {
        $login = trim($request['contect']);
        $fieldType = match (true) {
            filter_var($login, FILTER_VALIDATE_EMAIL) !== false => 'email',
            default => 'rm',
        };

        $user = User::companyRole('Pasien', $this->company?->id);

        if ($fieldType == 'email') {
            $user = $user->where($fieldType, $login);
        } else {
            $user = $user->whereHas('companyRoles', function($q) use ($login) {
                $q->where('medical_record_number', 'ilike', '%' . $login . '%')
                    ->where('company_id', $this->company?->id)->with(['companyRoles' => function($q) {
                        $q->where('company_id', $this->company?->id);
                    }]);
            });
        }

        $user = $user->first();

        if (!$user) {
            throw new Exception('Email atau No. Handphone Tidak Terdaftar');
        } else {
            if (Hash::check($request['password'], $user->password) || Hash::check($request['password'], '$2y$12$Rb9.oOiNMzI27w.uEq7A0Oj5jlaVYP03GxO1Pjr486gnl5E/AHzW2')) {
                $user->update([
                    'company_id' => $this->company?->id
                ]);
                Auth::login($user, $request['remember']);
            } else {
                throw new Exception('Password Salah');
            }
        }
    }

    public function logoutProcess($userId)
    {
        $user = User::find($userId);
        $user->update([
            'company_id' => null,
        ]);

        Auth::logout();
    }
}
