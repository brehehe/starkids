<?php

namespace App\Helpers;

use App\Models\Role\RoleCompany;
use App\Models\Spatie\Role;
use App\Models\User\UserCompanyRole;
use Carbon\Carbon;

class RoleHelper
{
    public static function assignRoleToUserInCompany($user, $roleName, $companyId, $medicalRecordNumber = null, $is_head = null, $is_active = null, $getRoleName = null)
    {
        $is_head = $is_head ?? false;
        $is_active = $is_active ?? true;

        $user->is_head = $is_head;
        $user->is_active = $is_active;
        $user->save();

        // Cari role global dulu
        $role = Role::where('name', $roleName)->first();

        if (! empty($getRoleName)) {
            $user->syncRoles($getRoleName);
        } else {
            $user->syncRoles($role->name);
        }
        // Cari mapping role_company sesuai role_id dan company_id
        $roleCompany = RoleCompany::firstOrCreate([
            'role_id' => $role->uuid,
            'company_id' => $companyId,
        ]);

        // 🔹 Ambil MRN lama kalau user sebelumnya sudah pernah jadi pasien
        $oldMrn = UserCompanyRole::where('user_id', $user->id)
            ->where('company_id', $companyId)
            ->where('role_id', function ($q) {
                $q->select('uuid')->from('roles')->where('name', 'Pasien')->limit(1);
            })
            ->value('medical_record_number');

        // 🔄 Buat mapping baru
        UserCompanyRole::updateOrCreate([
            'user_id' => $user->id,
            'company_id' => $companyId,
            'role_id' => $role->uuid,
            'role_company_id' => $roleCompany->id,
        ], [
            'medical_record_number' => $oldMrn // gunakan MRN lama kalau ada
                ?? ($medicalRecordNumber // kalau input manual ada, pakai itu
                    ?? ($role->name == 'Pasien'
                        ? 'PMR'.date('ymd').str_pad(
                            UserCompanyRole::where('company_id', $companyId)
                                ->whereDate('created_at', Carbon::now())
                                ->count() + 1,
                            5,
                            '0',
                            STR_PAD_LEFT
                        )
                        : null)),
            'is_head' => $is_head,
            'is_active' => $is_active,
        ]);
    }

    public static function hasCompanyRole($user, string $roleName, string $companyId): bool
    {
        // Cari role global
        $role = Role::where('name', $roleName)->first();

        if (! $role) {
            return false;
        }

        // Cari mapping role_company
        $roleCompany = RoleCompany::where('role_id', $role->uuid)
            ->where('company_id', $companyId)
            ->first();

        if (! $roleCompany) {
            $roleCompany = RoleCompany::create([
                'role_id' => $role->uuid,
                'company_id' => $companyId,
            ]);
        }

        // Cek di tabel user_company_role dengan role_company_id
        return UserCompanyRole::where('user_id', $user->id)
            ->where('role_id', $role->uuid)
            ->where('role_company_id', $roleCompany->id)
            ->where('company_id', $companyId)
            ->exists();
    }
}
