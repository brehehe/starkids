<?php

namespace App\Livewire\Admin\Master\Patient;

use App\Helpers\AlertHelper;
use App\Helpers\RoleHelper;
use App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender;
use App\Models\Master\CodeSystem\Patient\MasterPatientMaritalStatus;
use App\Models\Patient\OneHealth\OneHealthPatient;
use App\Models\Patient\Patient;
use App\Models\Role\RoleCompany;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserDetail;
use App\Models\User\UserType;
use App\service\apiservice;
use App\Traits\OneHealth\AuthenticateTrait;
use App\Traits\Region\RegionTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMasterPatientIndex extends Component
{
    use AuthenticateTrait, RegionTrait, WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'searchUser' => ['except' => ''],
    ];

    public $search = '';

    public $searchUser = '';

    public $perPage = 5;

    public $perPagePatient = 5;

    // User
    public $data_id;

    public $name;

    public $username;

    public $email;

    public $phone;

    public $user_id;

    public $user_type_id;

    public $user_detail;

    public $identity_card_mother = false; // Untuk NIK Ibu, default tidak terpilih

    // User Detail
    public $address;

    public $ihs_number;

    public $identity_card;

    public $blood_group;

    public $administrative_gender;

    public $birth_date;

    public $marital_status;

    public $province_code;

    public $city_code;

    public $district_code;

    public $sub_district_code;

    public $rt_code;

    public $rw_code;

    public $postal_code;

    // Array
    public $maritalStatusDetails = [];

    public $administrativeGenderDetails = [];

    public $provinces = [];

    public $cities = [];

    public $districts = [];

    public $subDistricts = [];

    public $user_types = [];

    // public $getDays = [
    //     'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
    // ];

    public function mount()
    {
        Session::forget('patient_id');

        $this->maritalStatusDetails = MasterPatientMaritalStatus::select('code', 'display')->get()->map(function ($item) {
            return [
                'code' => $item->code,
                'display' => $item->display,             // versi asli
                'display_ind' => $item->display_ind,     // otomatis dari accessor
            ];
        });

        $this->administrativeGenderDetails = MasterPatientAdministrativeGender::select('code', 'display')
            ->whereIn('code', ['male', 'female'])
            ->get()
            ->toArray();

        $this->user_types = UserType::select('id', 'name')->get()->pluck('name', 'id')->toArray();

        $this->provinces = $this->getProvinceTrait();
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

    public function openModal()
    {
        $this->provinces = $this->getProvinceTrait();

        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->reset([
            'data_id',
            'name',
            // 'username',
            'email',
            'phone',
            'address',
            'ihs_number',
            'identity_card',
            'blood_group',
            'administrative_gender',
            'birth_date',
            'marital_status',
            'provinces',
            'cities',
            'districts',
            'subDistricts',
            'province_code',
            'city_code',
            'district_code',
            'sub_district_code',
            'user_id',
            'user_detail',
            'rt_code',
            'rw_code',
            'user_type_id',
            'postal_code',
            'identity_card_mother', // Reset NIK Ibu
        ]);
        $this->resetValidation();

        return $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function hydrate()
    {
        $this->resetPage();
        $this->resetPage('pagePatient');
    }

    public function edit($id)
    {
        $this->provinces = $this->getProvinceTrait();
        $user = User::findOrFail($id);
        $this->data_id = $user->id;
        $this->name = $user->name;
        $this->user_id = $user->user_id;
        $this->user_detail = $user->user ? $user?->user?->name.' ('.($user?->user?->userDetail ? $user?->user?->userDetail?->address : '-').')' : '-';
        $this->user_type_id = $user->user_type_id;
        // $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = trim($user->phone);

        $patient = Patient::where('user_id', $user->id)->first();
        if ($patient) {
            $this->identity_card_mother = $patient->identity_card_mother;
        }
        if ($user->userDetail) {

            $this->address = $user->userDetail->address;
            $this->identity_card = $user->userDetail->identity_card; // Sekarang otomatis decrypt lewat accessor
            $this->blood_group = $user->userDetail->blood_group;
            $this->administrative_gender = $user->userDetail->administrative_gender;
            $this->birth_date = $user->userDetail->birth_date ? $user->userDetail->birth_date->format('Y-m-d') : null;
            $this->marital_status = $user->userDetail->marital_status;
            $this->province_code = $user->userDetail->province_code;
            $this->city_code = $user->userDetail->city_code;
            $this->district_code = $user->userDetail->district_code;
            $this->sub_district_code = $user->userDetail->sub_district_code;
            $this->postal_code = $user->userDetail->postal_code;
            $this->rt_code = $user->userDetail->rt;
            $this->rw_code = $user->userDetail->rw;
            $this->cities = $this->getCityTrait($this->province_code);
            $this->districts = $this->getDistrictTrait($this->city_code);
            $this->subDistricts = $this->getSubDistrictTrait($this->district_code);
        }
        $this->openModal();
    }

    protected function rules()
    {
        try {
            $currentCompanyId = Auth::user()->company_id;
            Log::info('Rules method called', [
                'current_company_id' => $currentCompanyId,
                'current_user_id' => Auth::user()->id ?? 'unknown',
                'current_user_name' => Auth::user()->name ?? 'unknown',
            ]);
        } catch (\Exception $e) {
            Log::error('Could not get current user in rules method', [
                'error' => $e->getMessage(),
            ]);
            $currentCompanyId = null;
        }

        return [
            'name' => 'required|string|max:255',
            'identity_card' => [
                'nullable',
                'string',
                'digits:16',
                'regex:/^[0-9]{16}$/',
                function ($attribute, $value, $fail) use ($currentCompanyId) {
                    $this->validateUniqueIdentityCard($value, $currentCompanyId, $fail);
                },
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                function ($attribute, $value, $fail) use ($currentCompanyId) {
                    $this->validateUniqueContactInfo('email', $value, $currentCompanyId, $fail);
                },
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s\(\)]*$/', // hanya angka, +, -, spasi, dan kurung
                function ($attribute, $value, $fail) use ($currentCompanyId) {
                    if ($currentCompanyId) {
                        $this->validateUniqueContactInfo('phone', $value, $currentCompanyId, $fail);
                    } else {
                        Log::warning('Skipping phone validation - no current company ID');
                    }
                },
            ],
            'user_type_id' => 'required|exists:user_types,id',
            'address' => 'required|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'administrative_gender' => 'nullable|in:male,female',
            'birth_date' => 'required|date|before:today',
            'marital_status' => 'nullable',
            'rt_code' => 'nullable',
            'rw_code' => 'nullable',
        ];
    }

    /**
     * Custom validation messages
     */
    protected function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'identity_card.required' => 'NIK wajib diisi',
            'identity_card.digits' => 'NIK harus terdiri dari 16 digit',
            'identity_card.regex' => 'NIK hanya boleh berisi angka',
            // 'username.required' => 'Username wajib diisi',
            // 'username.min' => 'Username minimal 4 karakter',
            // 'username.regex' => 'Username tidak boleh mengandung spasi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.regex' => 'Format nomor telepon tidak valid',
            'address.required' => 'Alamat wajib diisi',
            'administrative_gender.required' => 'Jenis kelamin wajib dipilih',
            'administrative_gender.in' => 'Jenis kelamin harus male atau female',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini',
            'postal_code.required' => 'Kode pos wajib diisi',
            'marital_status.required' => 'Status pernikahan wajib dipilih',
            'rt_code' => 'RT wajib diisi',
            'rw_code' => 'RW wajib diisi',
            'user_type_id.required' => 'Tipe user wajib dipilih',
        ];
    }

    /**
     * Main submit method
     */
    public function submit()
    {
        \Log::info('Patient submit method called', [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'data_id' => $this->data_id,
            'user_id' => auth()->id(),
        ]);

        $currentCompanyId = auth()->user()->company_id;
        \Log::info('Current company ID: '.$currentCompanyId);

        // Cleanup orphaned users before attempting to create new one
        if (! $this->data_id) { // Only for new patients, not updates
            $this->cleanupOrphanedUsers(
                $this->email,
                $this->phone,
                $this->username
            );
        }

        $createdUser = null; // Track user yang baru dibuat untuk cleanup jika diperlukan

        try {
            DB::beginTransaction();

            // Validate input
            $this->validate();
            \Log::info('Validation passed successfully');

            if (strlen($this->phone) > 15) {
                return AlertHelper::error('Gagal', 'Nomor telepon tidak boleh lebih dari 15 karakter.');
            }

            if ($this->identity_card_mother && $this->birth_date) {
                $birthDate = Carbon::parse($this->birth_date);

                // hitung selisih hari dari sekarang
                $diffInDays = $birthDate->diffInDays(now());

                if ($diffInDays > 60) {
                    return AlertHelper::error(
                        'Gagal',
                        'Tidak bisa menambahkan dengan NIK ibu karena tanggal lahir lebih dari 60 hari.'
                    );
                }
            }

            // Handle user creation/update
            $userResult = $this->handlePatientIdentityResolution($currentCompanyId);

            if (! $userResult['success']) {
                DB::rollBack();
                \Log::error('Failed to handle patient identity: '.$userResult['message']);

                return AlertHelper::error('Gagal', $userResult['message']);
            }

            $user = $userResult['user'];

            // Simpan referensi user baru untuk cleanup jika diperlukan
            if (! $userResult['is_update']) {
                $createdUser = $user;
            }

            \Log::info('Patient handled successfully', ['user_id' => $user->id]);

            // Update user detail
            $this->updateUserDetail($user);

            // Assign patient role
            $this->assignPatientRole($user, $currentCompanyId);

            // Handle API calls dengan try-catch terpisah untuk tidak memblokir proses utama
            $this->handlePatientAPIIntegration($user);

            DB::commit();

            $this->closeModal();
            AlertHelper::success('Berhasil', $userResult['is_update'] ? 'Patient berhasil diperbarui.' : 'Patient berhasil ditambahkan.');

            \Log::info('Patient successfully saved', ['user_id' => $user->id]);
        } catch (ValidationException $e) {
            DB::rollBack();

            // Cleanup user yang baru dibuat jika ada error validasi
            if ($createdUser) {
                $this->cleanupFailedUser($createdUser);
            }

            $errorMessages = collect($e->errors())->flatten()->implode(' ');
            AlertHelper::error('Validasi Gagal', $errorMessages);

            \Log::error('Validation error saving patient', [
                'user_id' => auth()->id(),
                'errors' => $e->errors(),
                'data' => $this->getPatientData(),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            // Cleanup user yang baru dibuat jika ada error
            if ($createdUser) {
                $this->cleanupFailedUser($createdUser);
            }

            AlertHelper::error('Gagal', 'Patient gagal disimpan: '.$th->getMessage());

            \Log::error('Error saving patient', [
                'user_id' => auth()->id(),
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'data' => $this->getPatientData(),
            ]);
        }
    }

    /**
     * Handle API integration with proper error handling
     */
    protected function handlePatientAPIIntegration($user)
    {
        try {
            $patient = Patient::where('user_id', $user->id)->first();
            $oneHealthPatient = OneHealthPatient::where('patient_id', $patient?->id)->first();

            if (! $patient || ! $oneHealthPatient || ! $oneHealthPatient->id_patient) {
                Log::info('Creating user via API service...');
                app(apiservice::class)->createUser($user, $this->identity_card_mother);
            }
        } catch (\Exception $e) {
            Log::error('API integration failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            // Jangan throw error untuk API failure, cukup log
            // Karena user sudah berhasil dibuat secara lokal
            Log::warning('Patient created locally but API integration failed', [
                'user_id' => $user->id,
                'api_error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Cleanup user yang gagal dibuat dengan lengkap
     */
    protected function cleanupFailedUser($user)
    {
        try {
            \Log::info('Cleaning up failed user creation', ['user_id' => $user->id]);

            // Hapus relasi terkait terlebih dahulu
            UserDetail::where('user_id', $user->id)->delete();
            UserCompanyRole::where('user_id', $user->id)->delete();
            Patient::where('user_id', $user->id)->delete();
            OneHealthPatient::whereHas('patient', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->delete();

            // Hapus user terakhir
            $user->delete();

            \Log::info('Failed user cleaned up successfully', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            \Log::error('Error cleaning up failed user', [
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
            $currentCompanyId = auth()->user()->company_id;
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
                    ->where('type_user', 'patient')
                    ->where('company_id', $currentCompanyId)
                    ->where(function ($query) {
                        $query->whereDoesntHave('userDetail')
                            ->orWhereDoesntHave('roles');
                    })
                    ->get();

                foreach ($orphanedUsers as $user) {
                    \Log::warning('Cleaning up orphaned user', [
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
            \Log::error('Error in cleanupOrphanedUsers', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Don't throw exception, just log it
        }
    }

    /**
     * Validasi unik untuk identity_card dengan enkripsi
     * Mempertimbangkan company_id, identity_card, name, dan identity_card_mother
     * Rule: NIK + Nama + Status NIK harus unik dalam company yang sama
     */
    protected function validateUniqueIdentityCard($identityCard, $companyId, $fail)
    {
        if (empty($identityCard)) {
            return;
        }

        Log::info('Validating identity card uniqueness', [
            'identity_card' => $identityCard,
            'company_id' => $companyId,
            'name' => $this->name,
            'identity_card_mother' => $this->identity_card_mother,
            'exclude_user_id' => $this->data_id,
        ]);

        // Cari semua user dengan NIK yang sama dalam company
        // ❌ Hapus ->withTrashed(), hanya validasi ke user aktif
        $query = User::whereHas('userDetail', function ($q) {
            // Filter dilakukan di loop karena perlu decrypt
        })
            ->where('company_id', $companyId)
            ->where('type_user', 'patient');

        // Exclude current user jika sedang update
        if ($this->data_id) {
            $query->where('id', '!=', $this->data_id);
        }

        $users = $query->with(['userDetail', 'patient'])->get();

        foreach ($users as $user) {
            if (! $user->userDetail || ! $user->userDetail->identity_card) {
                continue;
            }

            try {
                $decryptedIdentityCard = Crypt::decryptString($user->userDetail->identity_card);

                if ($decryptedIdentityCard === $identityCard) {
                    // NIK sama, cek kombinasi nama dan status identity_card_mother
                    $nameMatch = strtolower(trim($this->name)) === strtolower(trim($user->name));
                    $existingIdentityCardMother = $user->patient ? $user->patient->identity_card_mother : false;
                    $identityCardMotherMatch = $existingIdentityCardMother === $this->identity_card_mother;

                    // Jika nama sama DAN status identity_card_mother sama = duplikasi tidak diizinkan
                    if ($nameMatch && $identityCardMotherMatch) {
                        $nikStatus = $this->identity_card_mother ? 'NIK Ibu' : 'NIK Sendiri';
                        $errorMessage = "Kombinasi NIK '{$identityCard}', nama '{$this->name}', dan status '{$nikStatus}' sudah digunakan oleh pasien lain";

                        Log::warning('Identity card validation failed', [
                            'identity_card' => $identityCard,
                            'name' => $this->name,
                            'identity_card_mother' => $this->identity_card_mother,
                            'existing_user_id' => $user->id,
                            'existing_user_name' => $user->name,
                            'existing_identity_card_mother' => $existingIdentityCardMother,
                            'conflict_type' => 'exact_duplicate',
                        ]);

                        $fail($errorMessage);

                        return;
                    }

                    // NIK sama tapi kombinasi nama/status berbeda = diizinkan
                    Log::info('Same NIK with different combination allowed', [
                        'identity_card' => $identityCard,
                        'current_name' => $this->name,
                        'current_identity_card_mother' => $this->identity_card_mother,
                        'existing_name' => $user->name,
                        'existing_identity_card_mother' => $existingIdentityCardMother,
                        'name_match' => $nameMatch,
                        'status_match' => $identityCardMotherMatch,
                        'context' => 'Different person/status using same NIK (allowed)',
                    ]);
                }
            } catch (\Exception $e) {
                Log::warning('Failed to decrypt identity card', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);

                continue;
            }
        }

        Log::info('Identity card validation passed');
    }

    /**
     * Validasi untuk contact info (phone/email) dengan aturan BARU:
     * DIPERBOLEHKAN menggunakan contact info yang sama jika ada salah satu dari:
     * company_id, identity_card, name, atau identity_card_mother yang BERBEDA
     * HANYA DITOLAK jika SEMUA kriteria sama persis (exact duplicate)
     */
    protected function validateUniqueContactInfo($field, $value, $companyId, $fail)
    {
        if (empty($value)) {
            return;
        }

        Log::info('Validating contact info uniqueness (skip soft deleted)', [
            'field' => $field,
            'value' => $value,
            'company_id' => $companyId,
            'name' => $this->name,
            'identity_card' => $this->identity_card,
            'identity_card_mother' => $this->identity_card_mother,
            'exclude_user_id' => $this->data_id,
        ]);

        $query = User::where($field, $value)
            ->where('type_user', 'patient'); // tidak pakai withTrashed()

        if ($this->data_id) {
            $query->where('id', '!=', $this->data_id);
        }

        $existingUsers = $query->with(['userDetail', 'patient'])->get();

        foreach ($existingUsers as $existingUser) {
            $hasAnyDifference = $this->hasAnyDifferenceInCriteria($existingUser);

            if ($hasAnyDifference) {
                Log::info('Contact info ALLOWED - ada perbedaan kriteria', [
                    'field' => $field,
                    'value' => $value,
                    'existing_user_id' => $existingUser->id,
                    'different_criteria' => $this->findDifferentCriteria($existingUser),
                ]);

                continue;
            }

            // Jika SEMUA kriteria sama → tolak (karena user aktif)
            $fieldName = $this->getFieldDisplayName($field);
            $existingIdentityInfo = $this->getExistingUserIdentityInfo($existingUser);

            $errorMessage = "{$fieldName} '{$value}' sudah digunakan oleh pasien lain dengan identitas yang sama persis: {$existingUser->name} {$existingIdentityInfo}";

            Log::warning('Contact info validation FAILED - exact duplicate aktif', [
                'field' => $field,
                'value' => $value,
                'existing_user_id' => $existingUser->id,
                'reason' => 'All criteria sama persis pada user aktif',
            ]);

            $fail($errorMessage);

            return;
        }

        Log::info("Contact info validation PASSED untuk field: {$field}");
    }

    /**
     * Cek apakah user yang ada adalah orang yang sama berdasarkan kombinasi nama, NIK, dan identity_card_mother
     * Orang dianggap sama jika: nama sama + NIK sama + status identity_card_mother sama
     */
    protected function isSamePersonAdvanced($existingUser)
    {
        // Cek berdasarkan nama (case insensitive)
        $nameMatch = strtolower(trim($this->name)) === strtolower(trim($existingUser->name));

        // Jika nama tidak sama, bukan orang yang sama
        if (! $nameMatch) {
            return false;
        }

        // Cek berdasarkan NIK jika ada user detail
        if ($existingUser->userDetail && $existingUser->userDetail->identity_card && $this->identity_card) {
            try {
                $existingIdentityCard = Crypt::decryptString($existingUser->userDetail->identity_card);
                $identityCardMatch = $existingIdentityCard === $this->identity_card;

                // Jika NIK tidak sama, bukan orang yang sama
                if (! $identityCardMatch) {
                    return false;
                }

                // Cek status identity_card_mother
                $existingPatient = $existingUser->patient;
                $existingIdentityCardMother = $existingPatient ? $existingPatient->identity_card_mother : false;
                $identityCardMotherMatch = $existingIdentityCardMother === $this->identity_card_mother;

                // Orang yang sama jika: nama sama + NIK sama + status identity_card_mother sama
                return $identityCardMotherMatch;
            } catch (\Exception $e) {
                Log::warning('Failed to decrypt existing user identity card in isSamePersonAdvanced', [
                    'user_id' => $existingUser->id,
                    'error' => $e->getMessage(),
                ]);

                // Jika tidak bisa decrypt NIK, tidak bisa memastikan orang yang sama
                return false;
            }
        }

        // Jika tidak ada NIK untuk dibandingkan, tidak bisa memastikan orang yang sama
        return false;
    }

    /**
     * Cek apakah ada perbedaan dalam kriteria antara current input dengan existing user
     * Return TRUE jika ada perbedaan (contact sharing diperbolehkan)
     * Return FALSE jika semua sama (contact sharing ditolak)
     */
    protected function hasAnyDifferenceInCriteria($existingUser)
    {
        // Get current company ID dengan fallback
        $currentCompanyId = null;
        try {
            $currentCompanyId = Auth::user()->company_id ?? auth()->user()->company_id ?? null;
        } catch (\Exception $e) {
            Log::warning('Could not get current user company_id in hasAnyDifferenceInCriteria', [
                'error' => $e->getMessage(),
            ]);
        }

        Log::info('Checking criteria differences', [
            'current_company_id' => $currentCompanyId,
            'existing_user_id' => $existingUser->id,
            'existing_user_company_id' => $existingUser->company_id,
            'current_name' => $this->name,
            'existing_name' => $existingUser->name,
            'current_identity_card_mother' => $this->identity_card_mother,
            'existing_identity_card_mother' => $existingUser->patient ? $existingUser->patient->identity_card_mother : null,
        ]);

        // 1. Cek company_id
        $companyDifferent = false;
        if ($currentCompanyId && $existingUser->company_id !== $currentCompanyId) {
            Log::info('Company difference detected', [
                'current' => $currentCompanyId,
                'existing' => $existingUser->company_id,
            ]);

            return true; // Company berbeda = ada perbedaan = sharing diperbolehkan
        }

        // 2. Cek nama
        $nameMatch = strtolower(trim($this->name)) === strtolower(trim($existingUser->name));
        if (! $nameMatch) {
            Log::info('Name difference detected', [
                'current' => $this->name,
                'existing' => $existingUser->name,
            ]);

            return true; // Nama berbeda = ada perbedaan = sharing diperbolehkan
        }

        // 3. Cek NIK
        if ($existingUser->userDetail && $existingUser->userDetail->identity_card && $this->identity_card) {
            try {
                $existingIdentityCard = Crypt::decryptString($existingUser->userDetail->identity_card);
                $identityCardMatch = $existingIdentityCard === $this->identity_card;
                if (! $identityCardMatch) {
                    Log::info('NIK difference detected', [
                        'current_masked' => substr($this->identity_card, 0, 4).'****'.substr($this->identity_card, -4),
                        'existing_masked' => substr($existingIdentityCard, 0, 4).'****'.substr($existingIdentityCard, -4),
                    ]);

                    return true; // NIK berbeda = ada perbedaan = sharing diperbolehkan
                }
            } catch (\Exception $e) {
                Log::info('NIK comparison failed (treating as different)', [
                    'error' => $e->getMessage(),
                ]);

                return true; // Tidak bisa decrypt = anggap berbeda = sharing diperbolehkan
            }
        } else {
            Log::info('NIK not available for comparison (treating as different)', [
                'current_has_nik' => ! empty($this->identity_card),
                'existing_has_nik' => $existingUser->userDetail && $existingUser->userDetail->identity_card,
            ]);

            return true; // NIK tidak tersedia = anggap berbeda = sharing diperbolehkan
        }

        // 4. Cek status identity_card_mother
        $existingPatient = $existingUser->patient;
        $existingIdentityCardMother = $existingPatient ? $existingPatient->identity_card_mother : false;
        $identityCardMotherMatch = $existingIdentityCardMother === $this->identity_card_mother;
        if (! $identityCardMotherMatch) {
            Log::info('Identity card mother status difference detected', [
                'current' => $this->identity_card_mother ? 'mother' : 'self',
                'existing' => $existingIdentityCardMother ? 'mother' : 'self',
            ]);

            return true; // Status berbeda = ada perbedaan = sharing diperbolehkan
        }

        // Jika sampai sini, berarti SEMUA kriteria sama = TIDAK ada perbedaan = sharing DITOLAK
        Log::warning('All criteria are the same - sharing BLOCKED', [
            'company_match' => true,
            'name_match' => $nameMatch,
            'identity_card_match' => true,
            'identity_card_mother_match' => $identityCardMotherMatch,
        ]);

        return false;
    }

    /**
     * Helper method untuk mengidentifikasi kriteria mana yang berbeda
     * antara current input dengan existing user
     */
    protected function findDifferentCriteria($existingUser)
    {
        $differences = [];
        $currentCompanyId = Auth::user()->company_id;

        // 1. Cek company_id
        if ($existingUser->company_id !== $currentCompanyId) {
            $differences[] = 'company berbeda';
        }

        // 2. Cek nama
        $nameMatch = strtolower(trim($this->name)) === strtolower(trim($existingUser->name));
        if (! $nameMatch) {
            $differences[] = 'nama berbeda';
        }

        // 3. Cek NIK
        if ($existingUser->userDetail && $existingUser->userDetail->identity_card && $this->identity_card) {
            try {
                $existingIdentityCard = Crypt::decryptString($existingUser->userDetail->identity_card);
                $identityCardMatch = $existingIdentityCard === $this->identity_card;
                if (! $identityCardMatch) {
                    $differences[] = 'NIK berbeda';
                }
            } catch (\Exception $e) {
                $differences[] = 'NIK tidak dapat dibandingkan';
            }
        } else {
            $differences[] = 'NIK tidak tersedia untuk perbandingan';
        }

        // 4. Cek status identity_card_mother
        $existingPatient = $existingUser->patient;
        $existingIdentityCardMother = $existingPatient ? $existingPatient->identity_card_mother : false;
        $identityCardMotherMatch = $existingIdentityCardMother === $this->identity_card_mother;
        if (! $identityCardMotherMatch) {
            $currentStatus = $this->identity_card_mother ? 'NIK Ibu' : 'NIK Sendiri';
            $existingStatus = $existingIdentityCardMother ? 'NIK Ibu' : 'NIK Sendiri';
            $differences[] = "status NIK berbeda (sekarang: {$currentStatus}, yang ada: {$existingStatus})";
        }

        return $differences;
    }

    /**
     * Get informasi identitas user yang sudah ada untuk pesan error
     */
    protected function getExistingUserIdentityInfo($existingUser)
    {
        $info = [];

        if ($existingUser->userDetail && $existingUser->userDetail->identity_card) {
            try {
                $decryptedNik = Crypt::decryptString($existingUser->userDetail->identity_card);
                $maskedNik = substr($decryptedNik, 0, 4).str_repeat('*', 8).substr($decryptedNik, -4);
                $info[] = "NIK: {$maskedNik}";
            } catch (\Exception $e) {
                $info[] = 'NIK: [Terenkripsi]';
            }
        }

        if ($existingUser->patient) {
            $nikStatus = $existingUser->patient->identity_card_mother ? 'NIK Ibu' : 'NIK Sendiri';
            $info[] = "Status: {$nikStatus}";
        }

        return ! empty($info) ? '('.implode(', ', $info).')' : '';
    }

    /**
     * Validasi khusus untuk patient: email, phone, dan username harus unik
     * dalam company yang sama untuk type_user = patient
     */
    protected function validateUniquePatientInCompany($field, $value, $companyId, $fail)
    {
        if (empty($value)) {
            return;
        }

        Log::info('Validating patient uniqueness', [
            'field' => $field,
            'value' => $value,
            'company_id' => $companyId,
            'exclude_user_id' => $this->data_id,
        ]);

        // Cek duplikasi untuk patient dalam company yang sama
        // Hanya cari yang masih aktif (tidak termasuk soft deleted)
        $query = User::where($field, $value)
            ->where('type_user', 'patient')
            ->where('company_id', $companyId);

        // Exclude current user jika sedang update
        if ($this->data_id) {
            $query->where('id', '!=', $this->data_id);
        }

        $existingPatient = $query->first();

        if ($existingPatient) {
            $fieldName = $this->getFieldDisplayName($field);

            // Langsung gagal, karena existing aktif
            $errorMessage = "{$fieldName} '{$value}' sudah digunakan oleh pasien lain: {$existingPatient->name}";

            Log::warning('Patient validation failed', [
                'field' => $field,
                'value' => $value,
                'existing_patient_id' => $existingPatient->id,
                'existing_patient_name' => $existingPatient->name,
                'is_soft_deleted' => ! is_null($existingPatient->deleted_at),
            ]);

            $fail($errorMessage);

            return;
        }

        Log::info("Patient validation passed for field: {$field}");
    }

    /**
     * Get display name for field
     */
    protected function getFieldDisplayName($field)
    {
        $displayNames = [
            'email' => 'Email',
            'phone' => 'Nomor Telepon',
            'identity_card' => 'NIK',
            // 'username' => 'Username'
        ];

        return $displayNames[$field] ?? ucfirst($field);
    }

    /**
     * Handle patient identity resolution
     */
    protected function handlePatientIdentityResolution($companyId)
    {
        try {
            if ($this->data_id) {
                // Update existing patient
                return $this->updateExistingPatient($companyId);
            } else {
                // Create new patient
                return $this->createNewPatient($companyId);
            }
        } catch (\Exception $e) {
            Log::error('Error in handlePatientIdentityResolution', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'user' => null,
                'message' => $e->getMessage(),
                'is_update' => false,
            ];
        }
    }

    /**
     * Update existing patient
     */
    protected function updateExistingPatient($companyId)
    {
        $user = User::find($this->data_id);

        if (! $user) {
            throw new \Exception('Patient tidak ditemukan');
        }

        // Validasi additional checks
        if ($user->type_user !== 'patient') {
            throw new \Exception('User yang dipilih bukan patient');
        }

        if ($user->company_id !== $companyId) {
            throw new \Exception('Patient tidak dalam company yang sama');
        }

        // Update patient data
        $user->update([
            'name' => $this->name,
            // 'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_id' => $companyId,
            'user_type_id' => $this->user_type_id,
            'type_user' => 'patient',
            'updated_at' => now(),
        ]);

        Log::info('Patient updated successfully', ['user_id' => $user->id]);

        return [
            'success' => true,
            'user' => $user,
            'message' => 'Patient updated successfully',
            'is_update' => true,
        ];
    }

    /**
     * Create new patient
     */
    protected function createNewPatient($companyId)
    {
        $userData = [
            'name' => $this->name,
            'user_id' => $this->user_id,
            // 'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make('12345678'), // Default password
            'phone' => $this->phone,
            'user_type_id' => $this->user_type_id,
            'company_id' => $companyId,
            'type_user' => 'patient',
            'profile' => null,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $user = User::create($userData);

        Log::info('New patient created successfully', ['user_id' => $user->id]);

        return [
            'success' => true,
            'user' => $user,
            'message' => 'New patient created successfully',
            'is_update' => false,
        ];
    }

    /**
     * Update user detail
     */
    protected function updateUserDetail($user)
    {
        $detailData = [
            'address' => $this->address,
            'identity_card' => $this->identity_card, // Otomatis dienkripsi lewat mutator
            'blood_group' => $this->blood_group,
            'administrative_gender' => $this->administrative_gender,
            'birth_date' => $this->birth_date,
            'marital_status' => $this->marital_status,
            'province_code' => $this->province_code,
            'city_code' => $this->city_code,
            'district_code' => $this->district_code,
            'sub_district_code' => $this->sub_district_code,
            'rt' => $this->rt_code,
            'rw' => $this->rw_code,
            'postal_code' => $this->postal_code,
            'updated_at' => now(),
        ];

        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            $detailData
        );

        // Update atau create Patient record untuk menyimpan identity_card_mother
        $existingPatient = Patient::where('user_id', $user->id)->first();
        if ($existingPatient) {
            $existingPatient->update([
                'identity_card_mother' => $this->identity_card_mother,
                'updated_at' => now(),
            ]);
            Log::info('Patient identity_card_mother updated', [
                'user_id' => $user->id,
                'patient_id' => $existingPatient->id,
                'identity_card_mother' => $this->identity_card_mother,
            ]);
        } else {
            Log::info('Patient record not found, skipping identity_card_mother update', [
                'user_id' => $user->id,
            ]);
        }

        Log::info('Patient detail updated', ['user_id' => $user->id]);
    }

    /**
     * Assign patient role
     */
    protected function assignPatientRole($user, $companyId)
    {
        try {
            $role = Role::where('name', 'Pasien')->first();

            if (! $role) {
                throw new \Exception('Role Pasien tidak ditemukan');
            }

            $roleCompany = RoleCompany::where('company_id', $companyId)
                ->where('role_id', $role->uuid)
                ->first();

            if (! $roleCompany) {
                throw new \Exception('Role Pasien tidak tersedia untuk company ini');
            }

            // Check if role already assigned
            $existingRole = UserCompanyRole::where('user_id', $user->id)
                ->where('company_id', $companyId)
                ->where('role_id', $role->uuid)
                ->first();

            if (! $existingRole) {
                RoleHelper::assignRoleToUserInCompany(
                    $user,
                    $role->name,
                    $companyId,
                    null,
                    false,
                    true
                );

                Log::info('Patient role assigned', [
                    'user_id' => $user->id,
                    'role' => $role->name,
                    'company_id' => $companyId,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error assigning patient role', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Get patient data for logging
     */
    protected function getPatientData()
    {
        return [
            'name' => $this->name,
            // 'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'type_user' => 'patient',
            'company_id' => Auth::user()->company_id,
        ];
    }

    public function confirmDetail($user_id)
    {
        Session::put('patient_id', $user_id);

        return redirect()->route('user.consultation.patient.detail');
    }

    public function debugPatientValidation()
    {
        $currentCompanyId = Auth::user()->company_id;

        $conflicts = [
            'identity_card' => $this->findIdentityCardConflicts($this->identity_card, $currentCompanyId, $this->data_id),
            'email' => $this->findContactInfoConflicts('email', $this->email, $currentCompanyId, $this->data_id),
            'phone' => $this->findContactInfoConflicts('phone', $this->phone, $currentCompanyId, $this->data_id),
        ];

        Log::info('Patient validation debug', [
            'conflicts' => $conflicts,
            'current_data' => $this->getPatientData(),
        ]);

        return $conflicts;
    }

    /**
     * Find conflicts for identity card dengan pertimbangan nama, NIK, dan identity_card_mother
     * Updated untuk konsisten dengan validateUniqueIdentityCard
     */
    protected function findIdentityCardConflicts($identityCard, $companyId, $excludeUserId = null)
    {
        $conflicts = [];

        if (empty($identityCard)) {
            return $conflicts;
        }

        $query = User::whereHas('userDetail', function ($q) {
            // Filter akan dilakukan di loop karena perlu decrypt
        })->where('company_id', $companyId)
            ->where('type_user', 'patient')
            ->withTrashed();

        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        $users = $query->with(['userDetail', 'patient'])->get();

        foreach ($users as $user) {
            if (! $user->userDetail || ! $user->userDetail->identity_card) {
                continue;
            }

            try {
                $decryptedIdentityCard = Crypt::decryptString($user->userDetail->identity_card);

                if ($decryptedIdentityCard === $identityCard) {
                    // Cek kombinasi nama dan status identity_card_mother
                    $nameMatch = strtolower(trim($this->name)) === strtolower(trim($user->name));
                    $existingIdentityCardMother = $user->patient ? $user->patient->identity_card_mother : false;
                    $identityCardMotherMatch = $existingIdentityCardMother === $this->identity_card_mother;

                    // Tentukan tipe konflik berdasarkan kombinasi
                    if ($nameMatch && $identityCardMotherMatch) {
                        $conflictType = 'exact_duplicate'; // Duplikasi tidak diizinkan
                        $context = 'NIK, nama, dan status identity_card_mother sama (duplikasi tidak diizinkan)';
                    } else {
                        $conflictType = 'identity_shared'; // Berbagi NIK diizinkan
                        $context = 'NIK sama tapi kombinasi nama/status berbeda (diizinkan)';
                    }

                    $conflicts[] = [
                        'type' => $conflictType,
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'field' => 'identity_card',
                        'value' => $identityCard,
                        'context' => $context,
                        'name_match' => $nameMatch,
                        'identity_card_mother_match' => $identityCardMotherMatch,
                        'current_identity_card_mother' => $this->identity_card_mother,
                        'existing_identity_card_mother' => $existingIdentityCardMother,
                        'is_soft_deleted' => ! is_null($user->deleted_at),
                    ];
                }
            } catch (\Exception $e) {
                // Skip jika tidak bisa decrypt
                continue;
            }
        }

        return $conflicts;
    }

    /**
     * Find conflicts for contact info (email/phone) dengan pertimbangan advanced
     * Updated untuk konsisten dengan validateUniqueContactInfo
     */
    protected function findContactInfoConflicts($field, $value, $companyId, $excludeUserId = null)
    {
        $conflicts = [];

        if (empty($value)) {
            return $conflicts;
        }

        $query = User::where($field, $value)
            ->where('type_user', 'patient')
            ->where('company_id', $companyId)
            ->withTrashed();

        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        $patients = $query->with(['userDetail', 'patient'])->get();

        foreach ($patients as $patient) {
            // Cek apakah ini adalah orang yang sama menggunakan method advanced yang sudah diperbaiki
            $isSamePerson = $this->isSamePersonAdvanced($patient);

            $identityInfo = $this->getExistingUserIdentityInfo($patient);

            // Tentukan tipe konflik yang lebih detail
            if ($isSamePerson) {
                $conflictType = 'same_person_allowed';
                $context = 'Orang yang sama (nama + NIK + status identity_card_mother sama) - diizinkan';
            } else {
                $conflictType = 'contact_conflict';
                $context = 'Contact info sudah digunakan orang lain - tidak diizinkan';
            }

            $conflicts[] = [
                'type' => $conflictType,
                'user_id' => $patient->id,
                'user_name' => $patient->name,
                'field' => $field,
                'value' => $value,
                'context' => $context,
                'identity_info' => $identityInfo,
                'identity_card_mother' => $patient->patient ? $patient->patient->identity_card_mother : false,
                'current_identity_card_mother' => $this->identity_card_mother,
                'is_soft_deleted' => ! is_null($patient->deleted_at),
                'same_person_check' => [
                    'name_match' => strtolower(trim($this->name)) === strtolower(trim($patient->name)),
                    'identity_card_available' => ! empty($this->identity_card) && $patient->userDetail && $patient->userDetail->identity_card,
                    'same_person_result' => $isSamePerson,
                ],
            ];
        }

        return $conflicts;
    }

    public function render()
    {
        $patients = User::query()->with(['userDetail', 'patient.OHPatient', 'companyRoles.role'])->search($this->search)->role('Pasien');

        return view('livewire.admin.master.patient.admin-master-patient-index', [
            'patients' => $patients->paginate($this->perPage),
            'users' => User::query()->with(['userDetail', 'patient.OHPatient', 'companyRoles.role'])->where('id', '!=', $this->data_id)->search($this->searchUser)->role('Pasien')->paginate($this->perPagePatient, ['*'], 'pagePatient'),
        ])
            ->extends('layout.app')
            ->section('content');
    }

    public function openModalUser()
    {
        $this->dispatch('close-modal', ['id' => 'modal']);
        $this->dispatch('open-modal', ['id' => 'modal-user']);
    }

    public function closeModalUser()
    {
        $this->dispatch('close-modal', ['id' => 'modal-user']);
        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function getUser($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->user_detail = $user->name.' ('.$user->userDetail->address.')';
        $this->closeModalUser();
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda Yakin ingin Menghapus User', $id);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id[0]);
        if ($user->delete()) {
            Log::info('User deleted successfully', ['user_id' => $user->id]);
            AlertHelper::success('Berhasil', 'User berhasil dihapus');
        } else {
            Log::error('Failed to delete user', ['user_id' => $user->id]);
            AlertHelper::error('Gagal', 'Gagal menghapus User');
        }

        // return redirect()->route('admin.master.patient.index');
    }
}
