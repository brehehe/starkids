<?php

namespace App\Livewire\Admin\Master\Doctor;

use App\Helpers\AlertHelper;
use App\Helpers\RoleHelper;
use App\Http\Controllers\API\TestingController;
use App\Models\Doctor\Doctor;
use App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender;
use App\Models\Master\CodeSystem\Patient\MasterPatientMaritalStatus;
use App\Models\Practitiont\Practitioner;
use App\Models\Role\RoleCompany;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserDetail;
use App\Models\User\UserPrice;
use App\service\apiservice;
use App\Traits\Company\CompanyTrait;
use App\Traits\Region\RegionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class AdminMasterDoctorIndex extends Component
{
    use WithPagination, WithFileUploads, RegionTrait, CompanyTrait;

    protected $queryString = [
        // 'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'search' => ['except' => ''],
    ];

    public $search = '';

    public $perPage = 5;


    // User
    public $data_id;
    public $name;
    public $nik;
    public $username;
    public $email;
    public $password;
    public $profile;
    public $profile_old;
    public $phone;

    // User Detail
    public $address;
    public $identity_card;
    public $blood_group;
    public $administrative_gender;
    public $birth_date;
    public $deceased_date;
    public $marital_status;
    public $role_id;
    public $is_head = false;
    public $is_active = false;
    public $province_code;
    public $city_code;
    public $district_code;
    public $sub_district_code;
    public $doctor_id;
    public $country;
    public $rt_code;
    public $rw_code;
    public $longitude;
    public $latitude;
    public $altitude;

    public $companies = [];
    public $maritalStatusDetails = [];
    public $administrativeGenderDetails = [];
    public $roles = [];
    public $provinces = [];
    public $cities = [];
    public $districts = [];
    public $subDistricts = [];
    // Doctor
    public $sip_number;
    public $specialization;
    public $doctor_type = 'general';
    public $type = 'in';
    public $role_name;
    public $referral_percentage = 0;

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

    // Other
    public $practitioner_id;
    public $license_number;
    public $company_id;

    public function mount()
    {
        $this->administrativeGenderDetails = MasterPatientAdministrativeGender::whereIn('code', ['male', 'female'])->select('code', 'display')->get()->toArray();
        $this->maritalStatusDetails = MasterPatientMaritalStatus::select('code', 'display')->get()->map(function ($item) {
            return [
                'code' => $item->code,
                'display' => $item->display,             // versi asli
                'display_ind' => $item->display_ind,     // otomatis dari accessor
            ];
        });
        $this->provinces = $this->getProvinceTrait();
        $this->companies = $this->getCompanyBranches(Auth::user()?->company_id, ['id', 'name'])->toArray();
    }

    public function openModal()
    {
        $this->role_id = RoleCompany::where('company_id', auth()->user()->company_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'Dokter');
            })
            ->value('id');
        $this->role_name = RoleCompany::where('company_id', auth()->user()->company_id)
            ->whereHas('role', function ($query) {
                $query->where('name', 'Dokter');
            })
            ->first()->role->name;
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function resetInputFields()
    {
        $this->data_id = '';
        $this->name = '';
        $this->nik = '';
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->profile = null;
        $this->profile_old = null;
        $this->phone = '';

        // User Detail
        $this->address = '';
        $this->identity_card = '';
        $this->blood_group = '';
        $this->administrative_gender = '';
        $this->birth_date = '';
        $this->deceased_date = '';
        $this->marital_status = '';
        $this->role_id = '';
        $this->is_head = false;
        $this->is_active = false;
        $this->province_code = '';
        $this->city_code = '';
        $this->district_code = '';
        $this->sub_district_code = '';
        $this->doctor_id = '';
        $this->country = 'ID';
        $this->rt_code = '';
        $this->rw_code = '';
        $this->longitude = '0';
        $this->latitude = '0';
        $this->altitude = '0';

        // Doctor
        $this->sip_number = '';
        $this->specialization = '';
        $this->doctor_type = 'general';
        $this->type = 'in';
        $this->role_name = '';
        $this->referral_percentage = 0;

        // Price
        $this->incentive_doctor = 0;
        $this->incentive_pharmacy = 0;
        $this->incentive_nurse = 0;
        $this->incentive_cashier = 0;
        $this->price_doctor = 0;

        // Default
        $this->practitioner_id = '';
        $this->license_number = '';
    }

    public function searchNik()
    {
        if ($this->name == '' && $this->nik == '') {
            AlertHelper::error('Gagal', 'Nama dan NIK tidak boleh kosong');
            return;
        }

        if (!is_numeric($this->nik)) {
            AlertHelper::error('Gagal', 'NIK harus berupa angka');
            return;
        }

        if (strlen($this->nik) < 16) {
            AlertHelper::error('Gagal', 'NIK harus 16 digit');
            return;
        }

        $this->reset(['address', 'province_code', 'city_code', 'district_code', 'sub_district_code', 'birth_date', 'administrative_gender', 'doctor_id', 'marital_status', 'identity_card', 'blood_group', 'deceased_date', 'sip_number', 'specialization', 'doctor_type', 'type', 'role_name', 'referral_percentage', 'incentive_doctor', 'incentive_pharmacy', 'incentive_nurse', 'incentive_cashier', 'price_doctor', 'type_incentive_doctor', 'type_incentive_nurse', 'type_incentive_pharmacy', 'type_incentive_cashier', 'is_active', 'is_head', 'role_id', 'username', 'email', 'password', 'profile', 'profile_old', 'phone', 'doctor_id', 'rt_code', 'rw_code', 'longitude', 'latitude', 'altitude', 'country', 'license_number']);

        try {
            DB::beginTransaction();
            $data = [
                'company_id' => auth()->user()->company_id,
                'nik' => $this->nik,
                'name' => $this->name,
            ];

            $response = app(apiservice::class)->getPratition($data);


            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat mengambil data dokter');
            Log::error('Error fetching doctor data', ['data' => $data, 'error' => $e->getMessage()]);
            return;
        }

        if ($this->data_id) {
            $this->name = '';
            $this->nik = '';
            $this->username = '';
            $this->email = '';
            $this->password = '';
            $this->profile = null;
            $this->profile_old = null;
            $this->phone = '';

            // User Detail
            $this->address = '';
            $this->identity_card = '';
            $this->blood_group = '';
            $this->administrative_gender = '';
            $this->birth_date = '';
            $this->deceased_date = '';
            $this->marital_status = '';
            $this->role_id = '';
            $this->is_head = false;
            $this->is_active = false;
            $this->province_code = '';
            $this->city_code = '';
            $this->district_code = '';
            $this->sub_district_code = '';
            $this->doctor_id = '';
            $this->country = 'ID';
            $this->rt_code = '';
            $this->rw_code = '';
            $this->longitude = '0';
            $this->latitude = '0';
            $this->altitude = '0';

            // Doctor
            $this->sip_number = '';
            $this->specialization = '';
            $this->doctor_type = 'general';
            $this->type = 'in';
            $this->role_name = '';
            $this->referral_percentage = 0;

            // Price
            $this->incentive_doctor = 0;
            $this->incentive_pharmacy = 0;
            $this->incentive_nurse = 0;
            $this->incentive_cashier = 0;
            $this->price_doctor = 0;

            // Default
            $this->practitioner_id = '';
            $this->license_number = '';
            $this->edit($this->data_id);
        }

        $data = $response['data'] ?? null;

        // Check if data exists before accessing any properties
        if (!$data || !is_array($data)) {
            AlertHelper::warning('Peringatan', 'Data praktisi tidak ditemukan atau tidak valid');
            return;
        }

        $this->practitioner_id = $data['practitioner_id'] ?? '';

        // Address fields with safe access
        $address = $data['address'] ?? [];
        $this->address = is_array($address) ? ($address['address'] ?? '') : '';
        $this->doctor_id = $data['id_practitioner'] ?? '';
        $this->province_code = is_array($address) ? ($address['province_code'] ?? '') : '';
        $this->updatedProvinceCode();
        $this->city_code = is_array($address) ? ($address['city_code'] ?? '') : '';
        $this->updatedCityCode();
        $this->district_code = is_array($address) ? ($address['district_code'] ?? '') : '';
        $this->updatedDistrictCode();
        $this->sub_district_code = is_array($address) ? ($address['village_code'] ?? '') : '';

        // Basic fields with safe access
        $this->birth_date = $data['birth_date'] ?? '';

        // Gender field with comprehensive checking
        $this->administrative_gender = (isset($data['gender']) && !empty($data['gender']))
            ? optional(MasterPatientAdministrativeGender::whereIn('code', ['male', 'female'])->where('code', $data['gender'])->first())->code
            : null;

        // More address fields with safe access
        $this->country = is_array($address) ? ($address['country'] ?? 'ID') : 'ID';
        $this->rt_code = is_array($address) ? ($address['rt_code'] ?? '') : '';
        $this->rw_code = is_array($address) ? ($address['rw_code'] ?? '') : '';
        $this->longitude = is_array($address) ? ($address['longitude'] ?? '0') : '0';
        $this->latitude = is_array($address) ? ($address['latitude'] ?? '0') : '0';
        $this->altitude = is_array($address) ? ($address['altitude'] ?? '0') : '0';

        AlertHelper::success('Berhasil', 'ID Praktisi berhasil ditemukan.');
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

    public function getPratitionerId()
    {
        if ($this->nik == '') {
            AlertHelper::error('Gagal', 'NIK tidak boleh kosong');
            return;
        }

        if (!is_numeric($this->nik)) {
            AlertHelper::error('Gagal', 'NIK harus berupa angka');
            return;
        }

        if (strlen($this->nik) < 16) {
            AlertHelper::error('Gagal', 'NIK harus 16 digit');
            return;
        }

        $data = [
            'company_id' => auth()->user()->company_id,
            'nik' => $this->nik,
            'name' => $this->name,
        ];

        $response = app(apiservice::class)->getPratition($data);

        if ($response['success']) {
            $data = $response['data'] ?? null;
            $this->practitioner_id = $data['practitioner_id'] ?? '';
            AlertHelper::success('Berhasil', 'ID Praktisi berhasil ditemukan.');
        } else {
            AlertHelper::error('Gagal', $response['message']);
        }
    }

    public function submit()
    {
        $currentCompanyId = Auth::user()->company_id;

        $this->reset(['role_id', 'role_name']);

        $this->role_id = RoleCompany::where('company_id', $currentCompanyId)
            ->whereHas('role', function ($query) {
                $query->where('name', 'Dokter');
            })
            ->value('id');
        $this->role_name = RoleCompany::where('company_id', $currentCompanyId)
            ->whereHas('role', function ($query) {
                $query->where('name', 'Dokter');
            })
            ->first()->role->name;

        // Cleanup orphaned users before attempting to create new one
        if (!$this->data_id) { // Only for new employees, not updates
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
            'address' => 'required|string|max:500',
            'license_number' => 'required|string|max:30',
            'identity_card' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'administrative_gender' => 'required',
            'birth_date' => 'nullable|date',
            'deceased_date' => 'nullable|date',
            'marital_status' => 'nullable',
            'sip_number' => $this->role_name == 'Dokter' ? 'required' : 'nullable',
            'specialization' => $this->role_name == 'Dokter' ? 'required|string|max:100' : 'nullable',
            'doctor_type' => $this->role_name == 'Dokter' ? 'required' : 'nullable',
            // 'company_id' => 'required|exists:companies,id'
        ]);

        if (strlen($this->phone) > 15) {
            return AlertHelper::error('Gagal', 'Nomor telepon tidak boleh lebih dari 15 karakter.');
        }
        if (!$this->practitioner_id) {
            $this->getPratitionerId();

            if (!$this->practitioner_id) {
                return AlertHelper::error('Gagal', 'ID Praktisi tidak ditemukan. Silakan cari NIK terlebih dahulu.');
            } else {
                $this->practitioner_id = $this->practitioner_id;
            }
        }

        $createdUser = null; // Track user yang baru dibuat untuk cleanup jika diperlukan

        try {
            DB::beginTransaction();

            // Handle user creation/update with smart identity resolution
            $userResult = $this->handleUserIdentityResolution(Auth::user()->company_id ?? $currentCompanyId);

            if (!$userResult['success']) {
                DB::rollBack();
                return AlertHelper::error('Gagal', $userResult['message']);
            }

            $user = $userResult['user'];

            // Simpan referensi user baru untuk cleanup jika diperlukan
            if (!$userResult['is_update']) {
                $createdUser = $user;
            }

            // Update user detail
            $this->updateUserDetail($user);

            if ($this->role_name == 'Dokter') {
                $this->updateUserDoctor($user);
            }

            $practitioner = Practitioner::find($this->practitioner_id);
            $practitioner->user_id = $user->id;
            $practitioner->save();

            // Update user prices
            $this->updateUserPrices($user, $currentCompanyId);

            // Assign role (hanya untuk karyawan)
            $this->assignUserRole($user, $currentCompanyId);

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

            AlertHelper::error('Gagal', 'Pengguna gagal disimpan. ' . $th->getMessage());
            Log::error('Error saving user: ' . $th->getMessage(), [
                'user_id' => Auth::id(),
                'data' => [
                    'name' => $this->name,
                    'email' => $this->email,
                    'role_id' => $this->role_id,
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

            // Reset practitioner user_id if exists
            if ($this->practitioner_id) {
                $practitioner = Practitioner::find($this->practitioner_id);
                if ($practitioner && $practitioner->user_id == $user->id) {
                    $practitioner->user_id = null;
                    $practitioner->save();
                }
            }

            // Hapus user terakhir
            $user->delete();

            Log::info('Failed user cleaned up successfully', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Error cleaning up failed user', [
                'user_id' => $user->id,
                'cleanup_error' => $e->getMessage()
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
            if ($email) $cleanupCriteria['email'] = $email;
            if ($phone) $cleanupCriteria['phone'] = $phone;
            if ($username) $cleanupCriteria['username'] = $username;

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
                        'created_at' => $user->created_at
                    ]);

                    // Gunakan method cleanup yang sudah ada
                    $this->cleanupFailedUser($user);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in cleanupOrphanedUsers', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
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
        // Hanya cek user aktif (tidak termasuk soft deleted)
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

            Log::warning("Employee validation failed", [
                'field' => $field,
                'value' => $value,
                'existing_user_id' => $existingUser->id,
                'existing_user_name' => $existingUser->name,
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
            // 'username' => 'Username',
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
                'is_update' => false,
                'message' => 'New user created successfully',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'user' => null,
                'is_update' => false,
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
        if (!$user) {
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
            'is_update' => true,
            'message' => 'User updated successfully',
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
                'identity_card' => $this->nik,
                'blood_group' => $this->blood_group,
                'administrative_gender' => $this->administrative_gender,
                'birth_date' => $this->birth_date,
                'deceased_date' => $this->deceased_date,
                'marital_status' => $this->marital_status,
                'sip_number' => $this->sip_number,
                'specialization' => $this->specialization,
                'referral_percentage' => $this->referral_percentage ?: 0,
                'doctor_type' => $this->doctor_type,
                'type' => $this->type ?? 'in',
                'province_code' => $this->province_code,
                'city_code' => $this->city_code,
                'district_code' => $this->district_code,
                'sub_district_code' => $this->sub_district_code,
                'doctor_id' => $this->doctor_id,
                'country' => $this->country,
                'rt' => $this->rt_code,
                'rw' => $this->rw_code,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'altitude' => $this->altitude,
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
    protected function assignUserRole($user, $companyId)
    {
        $getRole = RoleCompany::find($this->role_id);
        if (!$getRole) {
            throw new \Exception('Role tidak ditemukan.');
        }

        $role = $getRole->role->name;
        RoleHelper::assignRoleToUserInCompany($user, $role, $companyId, null, $this->is_head, $this->is_active);
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

    public function updatedReferralPercentage()
    {
        if ($this->referral_percentage > 100) {
            $this->referral_percentage = 100;
        } elseif ($this->referral_percentage < 0) {
            $this->referral_percentage = 0;
        }

        $this->referral_percentage = intval($this->referral_percentage);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->data_id = $user->id;
        $this->name = $user->name;
        $this->nik = $user->userDetail ? $user->userDetail->identity_card : '';
        $this->username = $user->username;
        $this->email = $user->email;
        $this->profile_old = $user->profile;
        $this->phone = trim($user->phone);
        $this->company_id = $user->company_id;

        $this->role_id =
            $user
            ->companyRoles()
            ->where('company_id', Auth::user()->company_id)
            ->first()->role_company_id ?? null;
        $this->role_name =
            $user
            ->companyRoles()
            ->where('company_id', Auth::user()->company_id)
            ->first()->role->name ?? null;

        if ($user->userDetail) {
            $this->address = $user->userDetail->address;
            $this->identity_card = $user->userDetail->identity_card;
            $this->blood_group = $user->userDetail->blood_group;
            $this->administrative_gender = $user->userDetail->administrative_gender;
            $this->birth_date = $user->userDetail->birth_date->format('Y-m-d') ?? '';
            $this->deceased_date = $user->userDetail->deceased_date;
            $this->marital_status = $user->userDetail->marital_status;
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
            $this->province_code = $user->userDetail->province_code;
            $this->updatedProvinceCode();
            $this->city_code = $user->userDetail->city_code;
            $this->updatedCityCode();
            $this->district_code = $user->userDetail->district_code;
            $this->updatedDistrictCode();
            $this->sub_district_code = $user->userDetail->sub_district_code;
            $this->country = $user->userDetail->country ?? 'ID';
            $this->rt_code = $user->userDetail->rt;
            $this->rw_code = $user->userDetail->rw;
            $this->longitude = $user->userDetail->longitude ?? '0';
            $this->latitude = $user->userDetail->latitude ?? '0';
            $this->altitude = $user->userDetail->altitude ?? '0';
            if ($this->role_name == 'Dokter') {
                $this->sip_number = $user->userDetail->sip_number;
                $this->specialization = $user->userDetail->specialization;
                $this->referral_percentage = $user->userDetail->referral_percentage ?? 0;
                $this->license_number = $user->userDetail->license_number;
                $this->doctor_type = $user->userDetail->doctor_type ?? 'general';
                $this->incentive_doctor = number_format($user->userDetail->incentive_doctor ?? 0, 0, ',', '.');
                $this->type = $user->userDetail->type ?? 'in';
            }
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

        $practitioner = Practitioner::where('user_id', $user->id)->first();
        if ($practitioner) {
            $this->practitioner_id = $practitioner->id;
        } else {
            $this->practitioner_id = '';
        }

        $this->openModal();
    }

    public function render()
    {
        $user = User::role('Dokter')
            ->search($this->search)
            ->where('type_user', 'employee')
            ->orderBy('name', 'asc');
        $users = $user->paginate($this->perPage);
        return view('livewire.admin.master.doctor.admin-master-doctor-index', [
            'users' => $users,
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
