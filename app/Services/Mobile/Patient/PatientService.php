<?php

namespace App\Services\Mobile\Patient;

use App\Helpers\RoleHelper;
use App\Models\Company\Company;
use App\Models\Family\Family;
use App\Models\Family\FamilyMember;
use App\Models\Patient\OneHealth\OneHealthPatient;
use App\Models\Patient\Patient;
use App\Models\Role\RoleCompany;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use App\service\apiservice;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PatientService
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

    public function getPatient($userId)
    {
        $user = User::find($userId);

        if (! $user) return null;

        return $user;
    }

    public function getFamilyMember($userId)
    {
        $familyMember = FamilyMember::query()
            ->select(['id', 'family_id', 'user_id', 'relationship'])
            ->where('user_id', $userId)
            ->first();

        if (!$familyMember?->family_id) return null;

        $family = Family::query()
        ->with([
            'headUser:id,name',
            'members:id,family_id,user_id,relationship',
            'members.user:id,name,email',
            // Batasi data companyRoles (tanpa load company relation)
            'members.user.companyRoles' => function ($q) {
                // $q->select(['id', 'user_id', 'company_id', 'role', 'medical_record_number'])
                $q->select(['id', 'user_id', 'company_id', 'medical_record_number'])
                    ->where('company_id', $this->company?->id);
                    },
                ])
                ->find($familyMember?->family_id);

        if (!$family) return null;

        return $family?->members ?? [];
    }

    public function updateCreatePatient($data = [], $userId)
    {
        //user
        $patient = User::updateOrCreate(
            [
                'id' => (string)$userId
            ],
            [
                'name'         => $data['name'] ?? null,
                'user_id'      => $data['user_id'] ?? null,
                'username'     => isset($data['username']) ? Str::lower($data['username']) : null,
                'email'        => isset($data['email']) ? Str::lower($data['email']) : null,
                'password'     => isset($data['password']) ? Hash::make($data['password']) : Hash::make('12345678'),
                'phone'        => $data['phone'] ?? null,
                'user_type_id' => $data['user_type_id'] ?? null,
                'company_id'   => $this->company?->id,
                'type_user'    => 'patient',
                'email_verified_at' => now(),
            ]
        );

        //detail user
        $patient?->userDetail()->updateOrCreate(
            [
                'user_id' => $patient?->id
            ],
            [
                'address'               => $data['address'] ?? null,
                'identity_card'         => $data['identity_card'] ?? null,
                'administrative_gender' => $data['administrative_gender'] ?? null,
                'birth_date'            => $data['birth_date'] ?? null,
                'marital_status'        => $data['marital_status'] ?? null,
                'province_code'         => $data['province_code'] ?? null,
                'city_code'             => $data['city_code'] ?? null,
                'district_code'         => $data['district_code'] ?? null,
                'sub_district_code'     => $data['sub_district_code'] ?? null,
                'rt'                    => $data['rt_code'] ?? null,
                'rw'                    => $data['rw_code'] ?? null,
            ]
        );

        //patient
        $existingPatient = Patient::where('user_id', $patient?->id)->first();
        if ($existingPatient) {
            $existingPatient->update([
                'identity_card_mother' => $data['identity_card_mother'] ?? false,
                'updated_at' => now()
            ]);
        }

        //role
        $role = Role::where('name', 'Pasien')->first();

        if (!$role) {
            throw new \Exception('Role Pasien tidak ditemukan');
        }

        $roleCompany = RoleCompany::where('company_id', $this->company?->id)
            ->where('role_id', $role->uuid)
            ->first();

        if (!$roleCompany) {
            throw new \Exception('Role Pasien tidak tersedia untuk company ini');
        }

        $existingRole = UserCompanyRole::where('user_id', $patient->id)
            ->where('company_id', $this->company?->id)
            ->where('role_id', $role->uuid)
            ->first();

        if (!$existingRole) {
            RoleHelper::assignRoleToUserInCompany(
                $patient,
                $role->name,
                $this->company?->id,
                null,
                false,
                true
            );
        }

        return $patient;
    }

    public function handlePatientAPIIntegration($user, $data = [])
    {
        $patient = Patient::where('user_id', $user?->id)->first();
        $oneHealthPatient = OneHealthPatient::where('patient_id', $patient?->id)->first();

        if (!$patient || !$oneHealthPatient || !$oneHealthPatient?->id_patient) {
            app(apiservice::class)->createUser($user, $data['identity_card_mother'] ?? null);
        }
    }

    public function createFamilyMember($headUser, $newMember, $family = null, $data = [])
    {
        $familyMember = FamilyMember::where('user_id', $headUser?->id)->first();


        $family = Family::with(['members.user.companyRoles' => function($q) {
            $q->where('company_id', $this->company?->id);
            }, 'headUser'])->find($familyMember?->family_id);


        if (!$family) {
            $family = Family::create([
                'name'         => 'Keluarga ' . $headUser?->name,
                'head_user_id' => $headUser?->id,
                'company_id'   => $this->company?->id,
                ]);

            FamilyMember::create([
                'family_id'    => $family?->id,
                'user_id'      => $headUser?->id,
                'relationship' => 'kepala_keluarga',
                'company_id'   => $this->company?->id,
            ]);

            FamilyMember::create([
                'family_id'    => $family?->id,
                'user_id'      => $newMember?->id,
                'relationship' => $data['family_status'] ?? 'anggota',
                'company_id'   => $this->company?->id,
            ]);
        } else {
            FamilyMember::create([
                'family_id'    => $family->id,
                'user_id'      => $newMember?->id,
                'relationship' => $data['family_status'] ?? 'anggota',
                'company_id'   => $this->company?->id,
            ]);
        }
    }
}
