<?php

namespace App\Livewire\Admin\Master\User;

use App\Helpers\AlertHelper;
use App\Helpers\RoleHelper;
use App\Models\Company\Company;
use App\Models\Doctor\Doctor;
use App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender;
use App\Models\Master\CodeSystem\Patient\MasterPatientMaritalStatus;
use App\Models\Role\RoleCompany;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserDetail;
use App\Models\User\UserPrice;
use App\Traits\Region\RegionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AdminMasterUserIndex extends Component
{
    use RegionTrait, WithFileUploads, WithPagination;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;

    // User
    public $data_id;

    public $name;

    public $username;

    public $email;

    public $password;

    public $profile;

    public $profile_old;

    public $phone;

    public $company_id;

    // User Detail
    public $address;

    public $identity_card;

    public $blood_group;

    public $administrative_gender;

    public $birth_date;

    public $deceased_date;

    public $marital_status;

    public $role_ids = [];

    public $is_head = false;

    public $is_active = false;

    public $province_code;

    public $city_code;

    public $district_code;

    public $sub_district_code;

    public $rt_code;

    public $rw_code;

    public $maritalStatusDetails = [];

    public $administrativeGenderDetails = [];

    public $roles = [];

    public $provinces = [];

    public $cities = [];

    public $districts = [];

    public $subDistricts = [];

    public $companys = [];

    // Doctor
    public $sip_number;

    public $specialization;

    public $doctor_type = 'general';

    public $type = 'in';

    // Price
    public $incentive_doctor = 0;

    public $incentive_pharmacy = 0;

    public $incentive_nurse = 0;

    public $incentive_cashier = 0;

    public $price_doctor = 0;

    // Type Incentive
    public $type_incentive_doctor = 'rupiah';

    public $type_incentive_nurse = 'rupiah';

    public $type_incentive_pharmacy = 'rupiah';

    public $type_incentive_cashier = 'rupiah';

    public $license_number;

    public function mount()
    {
        $this->maritalStatusDetails = MasterPatientMaritalStatus::select('code', 'display')
            ->get()
            ->map(function ($item) {
                return [
                    'code' => $item->code,
                    'display' => $item->display, // versi asli
                    'display_ind' => $item->display_ind, // otomatis dari accessor
                ];
            });

        $this->administrativeGenderDetails = MasterPatientAdministrativeGender::select('code', 'display')
            ->whereIn('code', ['male', 'female'])
            ->get()
            ->toArray();

        $company = Auth::user()->company;

        $mainCompanyId = $company->is_main ? $company->id : $company->company_id;

        $this->companys = Company::select('id', 'name', 'is_main')
            ->where(function ($query) use ($mainCompanyId) {
                $query->where('company_id', $mainCompanyId)
                    ->orWhere('id', $mainCompanyId);
            })
            ->get()
            ->mapWithKeys(function ($company) {
                return [$company->id => $company->name_main];
            })
            ->toArray();

        $this->roles = RoleCompany::with([
            'role' => function ($query) {
                $query->where('name', 'not like', '%Pasien%')
                    ->where('name', 'not like', '%Dokter%');
            },
        ])
            ->select('id', 'role_id', 'company_id')
            ->where('company_id', auth()->user()->company_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'not like', '%Pasien%')
                    ->where('name', 'not like', '%Dokter%');
            })
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->role->name,
                ];
            })
            ->toArray();

        $this->provinces = $this->getProvinceTrait();
    }

    public function openModal()
    {
        $this->type_incentive_doctor = 'rupiah';
        $this->type_incentive_nurse = 'rupiah';
        $this->type_incentive_pharmacy = 'rupiah';
        $this->type_incentive_cashier = 'rupiah';
        $this->provinces = $this->getProvinceTrait();

        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->reset(['data_id', 'name', 'username', 'email', 'password', 'profile', 'profile_old', 'phone', 'address', 'identity_card', 'blood_group', 'administrative_gender', 'birth_date', 'deceased_date', 'marital_status', 'role_ids', 'is_head', 'is_active', 'sip_number', 'specialization', 'doctor_type', 'type', 'incentive_doctor', 'incentive_pharmacy', 'incentive_nurse', 'incentive_cashier', 'type_incentive_doctor', 'type_incentive_nurse', 'type_incentive_pharmacy', 'type_incentive_cashier', 'price_doctor', 'province_code', 'city_code', 'district_code', 'sub_district_code', 'provinces', 'cities', 'districts', 'subDistricts', 'rt_code', 'rw_code', 'license_number', 'company_id']);
        $this->resetErrorBag();
        $this->resetValidation();

        return $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function updatedProvinceCode()
    {
        $this->cities = $this->getCityTrait($this->province_code);
        $this->reset(['city_code', 'district_code', 'sub_district_code']);
    }

    public function updatedCityCode()
    {
        $this->districts = $this->getDistrictTrait($this->city_code);
        $this->reset(['district_code', 'sub_district_code']);
    }

    public function updatedDistrictCode()
    {
        $this->subDistricts = $this->getSubDistrictTrait($this->district_code);
        $this->reset('sub_district_code');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->data_id = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->profile_old = $user->profile;
        $this->phone = trim($user->phone);
        // dd($this->phone);
        $this->company_id = $user->company_id;

        $this->role_ids = UserCompanyRole::where('user_id', $user->id)
            ->pluck('role_company_id')
            ->toArray();

        if ($user->userDetail) {
            $this->address = $user->userDetail->address;
            $this->identity_card = $user->userDetail->identity_card;
            $this->blood_group = $user->userDetail->blood_group;
            $this->administrative_gender = $user->userDetail->administrative_gender;
            $this->birth_date = $user->userDetail->birth_date ? $user->userDetail->birth_date->format('Y-m-d') : null;
            $this->deceased_date = $user->userDetail->deceased_date;
            $this->marital_status = $user->userDetail->marital_status;
            $this->province_code = $user->userDetail->province_code;
            $this->updatedProvinceCode();
            $this->city_code = $user->userDetail->city_code;
            $this->updatedCityCode();
            $this->district_code = $user->userDetail->district_code;
            $this->updatedDistrictCode();
            $this->sub_district_code = $user->userDetail->sub_district_code;
            $this->rt_code = $user->userDetail->rt;
            $this->rw_code = $user->userDetail->rw;
            $this->license_number = $user->userDetail->license_number;
            $this->is_head =
                $user
                    ->companyRoles()
                    ->where('company_id', Auth::user()->company_id)
                    ->first()->is_head ?? false;
            $this->is_active =
                $user
                    ->companyRoles()
                    ->where('company_id', Auth::user()->company_id)
                    ->first()->is_active ?? false;
        }

        if ($user->userPrice) {
            $this->price_doctor = number_format($user->userPrice->price_doctor ?? 0, 0, ',', '.');
            $this->incentive_doctor = number_format($user->userPrice->incentive_doctor ?? 0, 0, ',', '.');
            $this->incentive_pharmacy = number_format($user->userPrice->incentive_pharmacy ?? 0, 0, ',', '.');
            $this->incentive_nurse = number_format($user->userPrice->incentive_nurse ?? 0, 0, ',', '.');
            $this->incentive_cashier = number_format($user->userPrice->incentive_cashier ?? 0, 0, ',', '.');
            $this->type_incentive_doctor = $user->userPrice->type_incentive_doctor ?? 'rupiah';
            $this->type_incentive_nurse = $user->userPrice->type_incentive_nurse ?? 'rupiah';
            $this->type_incentive_pharmacy = $user->userPrice->type_incentive_pharmacy ?? 'rupiah';
            $this->type_incentive_cashier = $user->userPrice->type_incentive_cashier ?? 'rupiah';
        } else {
            $this->type_incentive_doctor = 'rupiah';
            $this->type_incentive_nurse = 'rupiah';
            $this->type_incentive_pharmacy = 'rupiah';
            $this->type_incentive_cashier = 'rupiah';
            $this->price_doctor = 0;
            $this->incentive_doctor = 0;
            $this->incentive_pharmacy = 0;
            $this->incentive_nurse = 0;
            $this->incentive_cashier = 0;
        }

        $this->openModal();
    }

    public function updatedTypeIncentiveDoctor()
    {
        $this->incentive_doctor = 0; // Reset to 0 if switching to percentage
    }

    public function updatedTypeIncentiveNurse()
    {
        $this->incentive_nurse = 0; // Reset to 0 if switching to percentage
    }

    public function updatedTypeIncentivePharmacy()
    {
        $this->incentive_pharmacy = 0; // Reset to 0 if switching to percentage
    }

    public function updatedTypeIncentiveCashier()
    {
        $this->incentive_cashier = 0; // Reset to 0 if switching to percentage
    }

    public function updatedIncentiveDoctor()
    {
        $incentive_doctor = intval(Str::replace('.', '', $this->incentive_doctor));
        // Jika tipe insentif adalah persen, pastikan nilainya tidak lebih dari 100
        if ($this->type_incentive_doctor == 'persen' && $incentive_doctor > 100) {
            $this->incentive_doctor = 100;
        } else {
            $this->incentive_doctor = number_format($incentive_doctor, 0, ',', '.');
        }
    }

    public function updatedIncentiveNurse()
    {
        $incentive_nurse = intval(Str::replace('.', '', $this->incentive_nurse));
        // Jika tipe insentif adalah persen, pastikan nilainya tidak lebih dari 100
        if ($this->type_incentive_nurse == 'persen' && $incentive_nurse > 100) {
            $this->incentive_nurse = 100;
        } else {
            $this->incentive_nurse = number_format($incentive_nurse, 0, ',', '.');
        }
    }

    public function updatedIncentivePharmacy()
    {
        $incentive_pharmacy = intval(Str::replace('.', '', $this->incentive_pharmacy));
        // Jika tipe insentif adalah persen, pastikan nilainya tidak lebih dari 100
        if ($this->type_incentive_pharmacy == 'persen' && $incentive_pharmacy > 100) {
            $this->incentive_pharmacy = 100;
        } else {
            $this->incentive_pharmacy = number_format($incentive_pharmacy, 0, ',', '.');
        }
    }

    public function updatedIncentiveCashier()
    {
        $incentive_cashier = intval(Str::replace('.', '', $this->incentive_cashier));
        // Jika tipe insentif adalah persen, pastikan nilainya tidak lebih dari 100
        if ($this->type_incentive_cashier == 'persen' && $incentive_cashier > 100) {
            $this->incentive_cashier = 100;
        } else {
            $this->incentive_cashier = number_format($incentive_cashier, 0, ',', '.');
        }
    }

    public function submit()
    {
        $currentCompanyId = Auth::user()->company_id;

        // Cleanup orphaned users before attempting to create new one
        if (! $this->data_id) { // Only for new employees, not updates
            $this->cleanupOrphanedUsers(
                $this->email,
                $this->phone,
                $this->username
            );
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'nullable',
                'string',
                'min:4',
                'regex:/^\S*$/u', // tidak boleh ada spasi
                function ($attribute, $value, $fail) use ($currentCompanyId) {
                    $this->validateUniqueInCompany('username', $value, $currentCompanyId, $fail);
                },
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                function ($attribute, $value, $fail) use ($currentCompanyId) {
                    $this->validateUniqueInCompany('email', $value, $currentCompanyId, $fail);
                },
            ],
            'password' => $this->data_id ? 'nullable|string|min:8' : 'required|string|min:8',
            'profile' => 'nullable|image|max:2048',
            'phone' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($currentCompanyId) {
                    $this->validateUniqueInCompany('phone', $value, $currentCompanyId, $fail);
                },
            ],
            // 'company_id' => 'required|exists:companies,id',
            'role_ids' => 'required|array',
            'address' => 'required|string|max:500',
            'identity_card' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'administrative_gender' => 'nullable',
            'birth_date' => 'nullable|date',
            // 'province_code' => 'required',
            // 'city_code' => 'required',
            // 'district_code' => 'required',
            // 'sub_district_code' => 'required',
            'deceased_date' => 'nullable|date',
            'marital_status' => 'nullable',
        ]);

        if (strlen($this->phone) > 15) {
            return AlertHelper::error('Gagal', 'Nomor telepon tidak boleh lebih dari 15 karakter.');
        }

        $createdUser = null; // Track user yang baru dibuat untuk cleanup jika diperlukan

        try {
            DB::beginTransaction();

            // Handle user creation/update with smart identity resolution
            $userResult = $this->handleUserIdentityResolution($currentCompanyId);

            if (! $userResult['success']) {
                DB::rollBack();

                return AlertHelper::error('Gagal', $userResult['message']);
            }

            $user = $userResult['user'];

            // Simpan referensi user baru untuk cleanup jika diperlukan
            if (! $userResult['is_update']) {
                $createdUser = $user;
            }

            // Update user detail
            $this->updateUserDetail($user);

            // Update user prices
            $this->updateUserPrices($user, $currentCompanyId);

            // 🗑️ Hapus semua role lama di company ini
            UserCompanyRole::where('user_id', $user->id)
                ->where('company_id', $currentCompanyId)
                ->delete();

            $roleCompanys = RoleCompany::whereIn('id', $this->role_ids)->get();

            $getRoleName = Role::whereIn('uuid', $roleCompanys->pluck('role_id'))->pluck('name')->toArray();

            foreach ($roleCompanys as $roleCompany) {
                $this->assignUserRole($roleCompany->id, $user, $currentCompanyId, $getRoleName);
            }

            DB::commit();

            $this->closeModal();
            AlertHelper::success('Berhasil', 'Pengguna berhasil disimpan.');

            return;
        } catch (\Throwable $th) {
            DB::rollBack();

            // Cleanup user yang baru dibuat jika ada error
            if ($createdUser) {
                $this->cleanupFailedUser($createdUser);
            }

            AlertHelper::error('Gagal', 'Pengguna gagal disimpan. '.$th->getMessage());
            Log::error('Error saving user: '.$th->getMessage(), [
                'user_id' => Auth::id(),
                'data' => [
                    'name' => $this->name,
                    'email' => $this->email,
                    'role_ids' => $this->role_ids,
                    'type_user' => 'employee',
                ],
            ]);

            return;
        }
    }

    /**
     * Cleanup user yang gagal dibuat secara lengkap
     * Menghapus record yang mungkin tersisa dari proses yang gagal
     */
    protected function cleanupFailedUser($user)
    {
        try {
            Log::info('Cleaning up failed user creation', ['user_id' => $user->id]);

            // Hapus relasi terkait terlebih dahulu
            UserDetail::where('user_id', $user->id)->delete();
            UserCompanyRole::where('user_id', $user->id)->delete();
            Doctor::where('user_id', $user->id)->delete();
            UserPrice::where('user_id', $user->id)->delete();

            // Hapus user terakhir
            $user->delete();

            Log::info('Failed user cleaned up successfully', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Error cleaning up failed user', [
                'user_id' => $user->id,
                'cleanup_error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Cleanup user orphaned berdasarkan field values (email, phone, username)
     * Untuk membersihkan record yang mungkin tersisa dari proses yang gagal
     */
    private function cleanupOrphanedUsers($email = null, $phone = null, $username = null)
    {
        try {
            $currentCompanyId = Auth::user()->company_id;
            $cleanupCriteria = [];

            // Kumpulkan kriteria untuk pencarian
            if ($email) {
                $cleanupCriteria['email'] = $email;
            }
            if ($phone) {
                $cleanupCriteria['phone'] = $phone;
            }
            if ($username) {
                $cleanupCriteria['username'] = $username;
            }

            if (empty($cleanupCriteria)) {
                return;
            }

            foreach ($cleanupCriteria as $field => $value) {
                // Cari user yang incomplete (tanpa detail atau role)
                $orphanedUsers = User::where($field, $value)
                    ->where('type_user', 'employee')
                    ->where('company_id', $currentCompanyId)
                    ->where(function ($query) {
                        $query->whereDoesntHave('detail')
                            ->orWhereDoesntHave('roles');
                    })
                    ->get();

                foreach ($orphanedUsers as $user) {
                    Log::warning('Cleaning up orphaned user', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'username' => $user->username,
                        'name' => $user->name,
                        'created_at' => $user->created_at,
                    ]);

                    // Gunakan method cleanup yang sudah ada
                    $this->cleanupFailedUser($user);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in cleanupOrphanedUsers', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Don't throw exception, just log it
        }
    }

    /**
     * Validate unique dalam company context untuk employee
     */
    protected function validateUniqueInCompany($field, $value, $companyId, $fail)
    {
        if (empty($value)) {
            return;
        }

        // Query untuk mencari konflik dalam company yang sama
        // Hanya cek ke data aktif (tidak termasuk soft deleted)
        $query = User::where($field, $value)
            ->where('type_user', 'employee')
            ->where('company_id', $companyId);

        // Exclude user yang sedang di-update
        if ($this->data_id) {
            $query->where('id', '!=', $this->data_id);
        }

        $existingUser = $query->first();

        if ($existingUser) {
            $fieldLabel = $this->getFieldLabel($field);
            $errorMessage = "{$fieldLabel} '{$value}' sudah digunakan oleh karyawan lain dalam perusahaan ini ({$existingUser->name}).";

            Log::warning('Employee validation failed', [
                'field' => $field,
                'value' => $value,
                'existing_user_id' => $existingUser->id,
                'existing_user_name' => $existingUser->name,
                'is_soft_deleted' => ! is_null($existingUser->deleted_at),
            ]);

            $fail($errorMessage);
        }
    }

    /**
     * Get field label for error message
     */
    protected function getFieldLabel($field)
    {
        $labels = [
            'username' => 'Username',
            'email' => 'Email',
            'phone' => 'No. Telepon',
        ];

        return $labels[$field] ?? ucfirst($field);
    }

    /**
     * Handle user identity resolution with smart conflict handling
     */
    protected function handleUserIdentityResolution($companyId)
    {
        try {
            if ($this->data_id) {
                return $this->updateExistingUser($companyId);
            }

            // Untuk user baru, langsung buat tanpa mencari existing user
            // karena validasi uniqueness sudah dilakukan di atas
            $user = $this->createNewUser($companyId);

            return [
                'success' => true,
                'user' => $user,
                'message' => 'New user created successfully',
                'is_update' => false,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'user' => null,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function updateUserDoctor($user)
    {
        Doctor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'specialization' => $this->specialization,
                'type' => 'internal',
                'company_id' => Auth::user()->company_id,
            ]
        );
    }

    /**
     * Update existing user
     */
    protected function updateExistingUser($companyId)
    {
        $user = User::find($this->data_id);
        if (! $user) {
            throw new \Exception('User tidak ditemukan');
        }

        $password = $this->password ? Hash::make($this->password) : $user->password;

        $user->update([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $password,
            'profile' => $this->profile ? $this->profile->store('profiles', 'public') : $user->profile,
            'phone' => trim($this->phone),
            'company_id' => $companyId,
            'type_user' => 'employee',
        ]);

        return [
            'success' => true,
            'user' => $user,
            'message' => 'User updated successfully',
            'is_update' => true,
        ];
    }

    /**
     * Create new user
     */
    protected function createNewUser($companyId)
    {
        return User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'profile' => $this->profile ? $this->profile->store('profiles', 'public') : null,
            'phone' => trim($this->phone),
            'company_id' => $companyId,
            'type_user' => 'employee',
        ]);
    }

    /**
     * Update user detail
     */
    protected function updateUserDetail($user)
    {
        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            [
                'address' => $this->address,
                'identity_card' => $this->identity_card,
                'blood_group' => $this->blood_group,
                'administrative_gender' => $this->administrative_gender,
                'birth_date' => $this->birth_date,
                'deceased_date' => $this->deceased_date,
                'marital_status' => $this->marital_status,
                'sip_number' => $this->sip_number,
                'specialization' => $this->specialization,
                'doctor_type' => $this->doctor_type ?? 'general',
                'type' => $this->type ?? 'in',
                'province_code' => $this->province_code,
                'city_code' => $this->city_code,
                'district_code' => $this->district_code,
                'sub_district_code' => $this->sub_district_code,
                'rt' => $this->rt_code,
                'rw' => $this->rw_code,
                'license_number' => $this->license_number,
            ],
        );
    }

    /**
     * Update user prices
     */
    protected function updateUserPrices($user, $companyId)
    {
        UserPrice::updateOrCreate(
            [
                'user_id' => $user->id,
                'company_id' => $companyId,
            ],
            [
                'price_doctor' => $this->price_doctor ? intval(Str::replace('.', '', $this->price_doctor)) : 0,
                'type_incentive_doctor' => $this->type_incentive_doctor,
                'type_incentive_nurse' => $this->type_incentive_nurse,
                'type_incentive_pharmacy' => $this->type_incentive_pharmacy,
                'type_incentive_cashier' => $this->type_incentive_cashier,
                'incentive_doctor' => $this->incentive_doctor ? intval(Str::replace('.', '', $this->incentive_doctor)) : 0,
                'incentive_pharmacy' => $this->incentive_pharmacy ? intval(Str::replace('.', '', $this->incentive_pharmacy)) : 0,
                'incentive_nurse' => $this->incentive_nurse ? intval(Str::replace('.', '', $this->incentive_nurse)) : 0,
                'incentive_cashier' => $this->incentive_cashier ? intval(Str::replace('.', '', $this->incentive_cashier)) : 0,
            ],
        );
    }

    /**
     * Assign user role
     */
    protected function assignUserRole($role, $user, $companyId, $getRoleName)
    {
        $getRole = RoleCompany::find($role);

        $role = $getRole->role->name;
        RoleHelper::assignRoleToUserInCompany($user, $role, $companyId, null, $this->is_head, $this->is_active, $getRoleName);
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus pengguna ini?', $id);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id[0]);
        if ($user->id == Auth::id()) {
            return AlertHelper::error('Gagal', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        AlertHelper::success('Pengguna Berhasil Dihapus');
    }

    public function price($id)
    {
        $user = User::findOrFail($id);
        $this->data_id = $user->id;

        if ($user->userPrice) {
            $this->incentive_doctor = number_format($user->userPrice->incentive_doctor ?? 0, 0, ',', '.');
            $this->incentive_pharmacy = number_format($user->userPrice->incentive_pharmacy ?? 0, 0, ',', '.');
            $this->incentive_nurse = number_format($user->userPrice->incentive_nurse ?? 0, 0, ',', '.');
            $this->incentive_cashier = number_format($user->userPrice->incentive_cashier ?? 0, 0, ',', '.');
            $this->type_incentive_doctor = $user->userPrice->type_incentive_doctor ?? 'rupiah';
            $this->type_incentive_nurse = $user->userPrice->type_incentive_nurse ?? 'rupiah';
            $this->type_incentive_pharmacy = $user->userPrice->type_incentive_pharmacy ?? 'rupiah';
            $this->type_incentive_cashier = $user->userPrice->type_incentive_cashier ?? 'rupiah';
        } else {
            $this->type_incentive_doctor = 'rupiah';
            $this->type_incentive_nurse = 'rupiah';
            $this->type_incentive_pharmacy = 'rupiah';
            $this->type_incentive_cashier = 'rupiah';
            $this->incentive_doctor = 0;
            $this->incentive_pharmacy = 0;
            $this->incentive_nurse = 0;
            $this->incentive_cashier = 0;
        }

        return $this->dispatch('open-modal', ['id' => 'modal-price']);
    }

    public function closeModalPrice()
    {
        $this->reset(['data_id', 'incentive_doctor', 'incentive_pharmacy', 'incentive_nurse', 'incentive_cashier', 'type_incentive_doctor', 'type_incentive_nurse', 'type_incentive_pharmacy', 'type_incentive_cashier']);
        $this->resetErrorBag();
        $this->resetValidation();

        return $this->dispatch('close-modal', ['id' => 'modal-price']);
    }

    public function submitPrice()
    {
        $user = User::findOrFail($this->data_id);

        $this->validate([
            'incentive_doctor' => 'nullable|numeric',
            'incentive_pharmacy' => 'nullable|numeric',
            'incentive_nurse' => 'nullable|numeric',
            'incentive_cashier' => 'nullable|numeric',
            'type_incentive_doctor' => 'required|in:rupiah,persen',
            'type_incentive_nurse' => 'required|in:rupiah,persen',
            'type_incentive_pharmacy' => 'required|in:rupiah,persen',
            'type_incentive_cashier' => 'required|in:rupiah,persen',
        ]);
        try {
            DB::beginTransaction();

            UserPrice::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'company_id' => Auth::user()->company_id,
                ],
                [
                    'incentive_doctor' => $this->incentive_doctor ? intval(Str::replace('.', '', $this->incentive_doctor)) : 0,
                    'incentive_pharmacy' => $this->incentive_pharmacy ? intval(Str::replace('.', '', $this->incentive_pharmacy)) : 0,
                    'incentive_nurse' => $this->incentive_nurse ? intval(Str::replace('.', '', $this->incentive_nurse)) : 0,
                    'incentive_cashier' => $this->incentive_cashier ? intval(Str::replace('.', '', $this->incentive_cashier)) : 0,
                    'type_incentive_doctor' => $this->type_incentive_doctor,
                    'type_incentive_nurse' => $this->type_incentive_nurse,
                    'type_incentive_pharmacy' => $this->type_incentive_pharmacy,
                    'type_incentive_cashier' => $this->type_incentive_cashier,
                ]
            );

            DB::commit();

            return AlertHelper::success('Berhasil', 'Insentif berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            AlertHelper::error('Gagal', 'Insentif gagal disimpan. '.$th->getMessage());
            Log::error('Error saving user price: '.$th->getMessage(), [
                'user_id' => Auth::id(),
                'data' => [
                    'user_id' => $user->id,
                ],
            ]);
        }

    }

    public function render()
    {
        $company = Auth::user()->company;

        $companyIds = $company->is_main
            ? Company::where('company_id', $company->id)
                ->orWhere('id', $company->id)
                ->pluck('id')
                ->toArray() // <--- tambahkan ini
            : [$company->id]; // hanya cabang

        $user = User::role(['Super Admin', 'Perawat', 'Terapis', 'Apoteker', 'Kasir', 'Resepsionis'])
            ->search($this->search)
            ->where('type_user', 'employee')
            ->with('company:id,name,is_main')
            ->orderBy('name', 'asc');

        return view('livewire.admin.master.user.admin-master-user-index', [
            'users' => $user->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
