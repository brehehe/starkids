<?php

namespace App\Livewire\Admin\Consultation\Patient;

use App\Helpers\AlertHelper;
use App\Helpers\RoleHelper;
use App\Models\Branch\Branch;
use App\Models\Deposit\Deposit;
use App\Models\Deposit\DepositItem;
use App\Models\Encounter\Encounter;
use App\Models\Insurance\Insurance;
use App\Models\Location\Location;
use App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender;
use App\Models\Master\CodeSystem\Patient\MasterPatientMaritalStatus;
use App\Models\Patient\OneHealth\OneHealthPatient;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
use App\Models\Product\Product;
use App\Models\Role\RoleCompany;
use App\Models\Spatie\Role;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\User;
use App\Models\User\ControlDoctor;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserControlSchedule;
use App\Models\User\UserDetail;
use App\Models\User\UserPrice;
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

class AdminConsultationPatientIndex extends Component
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

    public $patient_id; // For selecting existing patient for deposit

    public $name;

    public $user_type_id;

    public $username;

    public $email;

    public $phone;

    public $user_id;

    public $user_detail;

    public $identity_card_mother = false;

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

    public $insurance_id;

    public $insurance_number;

    // Konsultasi
    public $doctor_id;

    public $doctor_referral_id;

    public $location_id;

    public $control_doctor_id;

    public $days;

    public $date;

    // Deposit
    public $deposit_id;

    public $selectedDepositId;

    // Array
    public $maritalStatusDetails = [];

    public $administrativeGenderDetails = [];

    public $doctors = [];

    public $doctor_referrals = [];

    public $locations = [];

    public $controlDoctors = [];

    public $provinces = [];

    public $cities = [];

    public $districts = [];

    public $subDistricts = [];

    public $user_types = [];

    public $insurances = [];

    public $availableDeposits = [];

    public $patientsList = []; // List of patients for dropdown (renamed to avoid conflict)

    public $filterBirthDate;

    public $user_control_schedules = [];

    public $user_control_schedule_id;

    public $is_insurance = false;
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

        $this->insurances = Insurance::where('company_id', Auth::user()->company_id)->select('id', 'name')->get()->toArray();

        $this->administrativeGenderDetails = MasterPatientAdministrativeGender::select('code', 'display')
            ->whereIn('code', ['male', 'female'])
            ->get()
            ->toArray();
        $this->doctors = User::select('id', 'name')->companyRole('Dokter', Auth::user()->company_id)->get()->toArray();
        $this->doctor_referrals = User::select('id', 'name')->companyRole('Dokter', Auth::user()->company_id)->get()->toArray();
        $this->locations = Location::where('company_id', Auth::user()->company_id)->select('id', 'name')->get()->toArray();

        // Load patients for deposit selection is disabled to prevent memory bloat,
        // because the deposit selection dropdown is currently commented out in the blade view.
        $this->patientsList = [];

        $this->date = now()->format('Y-m-d');
        $this->user_types = UserType::where('company_id', Auth::user()->company_id)
            ->get()
            ->pluck('name', 'id')
            ->toArray();

        $this->provinces = [];
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

    public function updatedLocationId()
    {
        $this->reset('days', 'control_doctor_id');
        $this->getControlDoctors();
    }

    public function updatedPatientId()
    {
        if ($this->patient_id) {
            $this->loadAvailableDeposits();
        } else {
            $this->availableDeposits = [];
            $this->selectedDepositId = null;
        }
    }

    public function loadAvailableDeposits()
    {
        if (! $this->patient_id) {
            $this->availableDeposits = [];

            return;
        }

        $this->availableDeposits = Deposit::where('patient_id', $this->patient_id)
            ->where('company_id', Auth::user()->company_id)
            // ->where('remaining_quantity', '>', 0)
            ->whereIn('status', ['success', 'partial'])
            ->whereRaw('remaining_quantity <= quantity') // Hanya tampilkan jika remaining_quantity masih dalam batas quantity
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($deposit) {
                $usedQuantity = $deposit->remaining_quantity;

                return [
                    'id' => $deposit->id,
                    'code' => $deposit->code,
                    'remaining_quantity' => $deposit->remaining_quantity,
                    'quantity' => $deposit->quantity,
                    'used_quantity' => $usedQuantity, // Tambahkan field untuk quantity yang sudah terpakai
                    'status' => $deposit->status,
                    'created_at' => $deposit->created_at->format('d/m/Y'),
                ];
            })
            ->toArray();
    }

    public function openModal()
    {
        // $this->identity_card = intval(rand(1000000000000000, 9999999999999999));
        $this->provinces = $this->getProvinceTrait();
        $this->date = now()->format('Y-m-d');

        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal()
    {
        $this->reset([
            'data_id',
            'patient_id',
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
            'doctor_id',
            'doctor_referral_id',
            'location_id',
            'control_doctor_id',
            'days',
            'date',
            'provinces',
            'cities',
            'districts',
            'subDistricts',
            'controlDoctors',
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
            'identity_card_mother',
            'deposit_id',
            'selectedDepositId',
            'availableDeposits',
            'user_control_schedule_id',
            'user_control_schedules',
            'is_insurance',
            'insurance_id',
            'insurance_number',
        ]);
        $this->resetValidation();

        return $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function hydrate()
    {
        // $this->resetPage();
        // $this->resetPage('pagePatient');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSearchUser()
    {
        $this->resetPage('pagePatient');
    }

    public function updatedDoctorId()
    {
        $this->reset('days', 'control_doctor_id');
        $this->getControlDoctors();
    }

    public function updatedDate()
    {
        // $this->mount();
        $this->reset('days', 'control_doctor_id');
        $this->getControlDoctors();
    }

    public function getControlDoctors()
    {

        if ($this->location_id && $this->doctor_id && $this->date) {
            $days = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];

            $englishDay = date('l', strtotime($this->date));
            $this->days = $days[$englishDay];

            $this->controlDoctors = ControlDoctor::where('location_id', $this->location_id)
                ->where('user_id', $this->doctor_id)
                ->where(function ($query) {
                    // Check if days JSONB contains the current day
                    $query->whereJsonContains('days', $this->days)
                        ->orWhere('is_unlimited', true);
                })
                ->get()
                ->filter(function ($item) {
                    // Skip quota check for unlimited doctors
                    if ($item->is_unlimited) {
                        return true;
                    }

                    $count = Transaction::where('control_doctor_id', $item->id)
                        ->where('location_id', $this->location_id)
                        ->where('doctor_id', $this->doctor_id)
                        ->whereDate('date', $this->date)
                        ->count();

                    return $count < $item->max_patients;
                })
                ->map(function ($item) {
                    // Hitung jumlah pasien terdaftar pada tanggal yang dipilih untuk dokter kontrol ini
                    $countTransactions = Transaction::where('control_doctor_id', $item->id)
                        ->where('location_id', $this->location_id)
                        ->where('doctor_id', $this->doctor_id)
                        ->whereDate('date', $this->date)
                        ->count();

                    // Handle unlimited doctors
                    $maxPatients = $item->is_unlimited ? null : $item->max_patients;
                    $remainingQuota = $item->is_unlimited ? null : ($item->max_patients - $countTransactions);
                    $isFull = $item->is_unlimited ? false : ($countTransactions >= $item->max_patients);

                    return [
                        'id' => $item->id,
                        'days' => $this->days, // Current selected day
                        'start_time' => $item->start_time,
                        'end_time' => $item->end_time,
                        'max_patients' => $maxPatients,
                        'current_patients' => $countTransactions,
                        'remaining_quota' => $remainingQuota,
                        'is_full' => $isFull,
                        'is_unlimited' => $item->is_unlimited,
                    ];
                })
                ->toArray();
        } else {
            $this->controlDoctors = [];
        }
    }

    public function edit($id)
    {
        try {
            Log::info('Edit method called with ID: '.$id, ['id_type' => gettype($id)]);

            $this->provinces = $this->getProvinceTrait();
            $user = User::findOrFail($id);

            Log::info('User found successfully', [
                'user_id' => $user->id,
                'user_type_id' => $user->user_type_id,
                'user_type_id_type' => gettype($user->user_type_id),
            ]);

            $this->data_id = $user->id;
            $this->name = $user->name;
            $this->user_id = $user->user_id;
            $this->user_detail = $user->user ? $user?->user?->name.' ('.($user?->user?->userDetail ? $user?->user?->userDetail?->address : '-').')' : '-';
            $this->user_type_id = $user->user_type_id ?? null;
            // $this->username = $user->username;
            $this->email = $user->email;
            $this->phone = trim($user->phone);

            $patient = Patient::where('user_id', $user->id)->first();
            $this->identity_card_mother = $patient ? $patient->identity_card_mother : false;
            if ($user->userDetail) {

                $this->address = $user->userDetail->address;
                $this->identity_card = $user->userDetail->identity_card;
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

            $this->user_control_schedules = UserControlSchedule::where('user_id', $user->id)
                ->select('id', 'description', 'date')
                ->where('company_id', Auth::user()->company_id)
                ->whereIn('status', ['draft', null])
                ->get()
                ->toArray();

            $this->insurances = [];
            $this->insurances = Insurance::where('company_id', Auth::user()->company_id)->select('id', 'name')->get()->toArray();

            Log::info('insurance', $this->insurances);

            Log::info('Edit method completed successfully');
            $this->openModal();
        } catch (\Exception $e) {
            Log::error('Error in edit method: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'id' => $id,
            ]);
            AlertHelper::error('Error', 'Gagal membuka form edit: '.$e->getMessage());
        }
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
            'email.email' => 'Format email tidak valid',
            'phone.required' => 'Nomor telepon wajib diisi',
            'phone.regex' => 'Format nomor telepon tidak valid',
            'address.required' => 'Alamat wajib diisi',
            'administrative_gender.required' => 'Jenis kelamin wajib dipilih',
            'administrative_gender.in' => 'Jenis kelamin harus male atau female',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini',
            'postal_code.required' => 'Kode pos wajib diisi',
            'marital_status.required' => 'Status pernikahan wajib dipilih',
            'location_id.required' => 'Poli wajib dipilih',
            'doctor_id.required' => 'Dokter wajib dipilih',
            'control_doctor_id.required' => 'Control doctor wajib dipilih',
            'rt_code.required' => 'RT wajib diisi',
            'rw_code.required' => 'RW wajib diisi',
            'user_type_id.required' => 'Tipe pasien wajib dipilih',
        ];
    }

    /**
     * Main submit method
     */
    public function submit()
    {
        Log::info('Patient submit method called', [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'user_type_id' => $this->user_type_id,
            'user_type_id_type' => gettype($this->user_type_id),
            // 'username' => $this->username,
            'data_id' => $this->data_id,
            'user_id' => Auth::id(),
        ]);

        $currentCompanyId = Auth::user()->company_id;
        Log::info('Current company ID: '.$currentCompanyId);

        // Cleanup orphaned users before attempting to create new one
        if (! $this->data_id) { // Only for new patients, not updates
            $this->cleanupOrphanedUsers(
                $this->email,
                $this->phone,
                $this->identity_card
            );
        }

        $createdUser = null; // Track user yang baru dibuat untuk cleanup jika diperlukan

        try {
            DB::beginTransaction();

            // Validate input
            Log::info('Starting validation...');
            $this->validate();
            Log::info('Validation passed successfully');

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

            // Get required models
            Log::info('Getting required models...');
            $location = Location::findOrFail($this->location_id);
            $doctor = User::findOrFail($this->doctor_id);

            // Handle user creation/update
            Log::info('Handling patient identity resolution...');
            $userResult = $this->handlePatientIdentityResolution($currentCompanyId);

            if (! $userResult['success']) {
                DB::rollBack();
                Log::error('Failed to handle patient identity: '.$userResult['message']);

                return AlertHelper::error('Gagal', $userResult['message']);
            }

            $user = $userResult['user'];

            // Simpan referensi user baru untuk cleanup jika diperlukan
            if (! $userResult['is_update']) {
                $createdUser = $user;
            }

            Log::info('Patient handled successfully', ['user_id' => $user->id]);

            // Update user detail
            Log::info('Updating user detail...');
            $this->updateUserDetail($user);

            $patient = Patient::where('user_id', $user->id)->first();

            $oneHealthPatient = OneHealthPatient::where('patient_id', $patient?->id)->first();
            if (! $patient || ! $oneHealthPatient || ! $oneHealthPatient->id_patient) {
                Log::info('Creating user via API service...');
                app(apiservice::class)->createUser($user, $this->identity_card_mother);
            }

            // Assign patient role
            Log::info('Assigning patient role...');
            $this->assignPatientRole($user, $currentCompanyId);

            // $auth = $this->accessToken($user->company);
            // dd($auth);
            // Create transaction if required
            if ($this->shouldCreateTransaction()) {
                Log::info('Creating patient transaction...');

                $this->createPatientTransaction($location, $doctor, $user, $currentCompanyId);
            }

            DB::commit();

            // $this->resetForm();
            $this->closeModal();

            AlertHelper::success('Berhasil', $userResult['is_update'] ? 'Patient berhasil diperbarui.' : 'Patient berhasil ditambahkan.');

            // $this->emit('patientSaved');
            Log::info('Patient successfully saved', ['user_id' => $user->id]);
        } catch (ValidationException $e) {
            DB::rollBack();

            // Cleanup user yang baru dibuat jika ada error validasi
            if ($createdUser) {
                $this->cleanupFailedUser($createdUser);
            }

            $errorMessages = collect($e->errors())->flatten()->implode(' ');
            AlertHelper::error('Validasi Gagal', $errorMessages);

            Log::error('Validation error saving patient', [
                'user_id' => Auth::id(),
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

            Log::error('Error saving patient', [
                'user_id' => Auth::id(),
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
                'data' => $this->getPatientData(),
            ]);
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
            Patient::where('user_id', $user->id)->delete();
            OneHealthPatient::whereHas('patient', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->delete();

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
     * Cleanup user orphaned berdasarkan field values (email, phone, identity_card)
     * Untuk membersihkan record yang mungkin tersisa dari proses yang gagal
     */
    private function cleanupOrphanedUsers($email = null, $phone = null, $identity_card = null)
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
            if ($identity_card) {
                $cleanupCriteria['identity_card'] = $identity_card;
            }

            if (empty($cleanupCriteria)) {
                return;
            }

            foreach ($cleanupCriteria as $field => $value) {
                if ($field === 'identity_card') {
                    // Untuk identity_card, cari di UserDetail
                    $orphanedUserDetails = UserDetail::where('identity_card', $value)->get();

                    foreach ($orphanedUserDetails as $userDetail) {
                        $user = User::where('id', $userDetail->user_id)
                            ->where('type_user', 'patient')
                            ->where('company_id', $currentCompanyId)
                            ->where(function ($query) {
                                $query->whereDoesntHave('detail')
                                    ->orWhereDoesntHave('roles');
                            })
                            ->first();

                        if ($user) {
                            Log::warning('Cleaning up orphaned user by identity_card', [
                                'user_id' => $user->id,
                                'email' => $user->email,
                                'phone' => $user->phone,
                                'identity_card' => $value,
                                'name' => $user->name,
                                'created_at' => $user->created_at,
                            ]);

                            $this->cleanupFailedUser($user);
                        }
                    }
                } else {
                    // Untuk email dan phone, cari langsung di User
                    $orphanedUsers = User::where($field, $value)
                        ->where('type_user', 'patient')
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
                            'name' => $user->name,
                            'created_at' => $user->created_at,
                        ]);

                        $this->cleanupFailedUser($user);
                    }
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
     * Validasi ketat untuk identity_card (NIK) - tidak boleh sama dalam company yang sama
     */
    protected function validateIdentityCardUniqueness($identityCard, $companyId, $fail)
    {
        // Cari semua user aktif dengan NIK yang sama dalam company
        $users = User::whereHas('userDetail', function ($q) {
            // Filter akan dilakukan di loop karena perlu decrypt
        })->where('company_id', $companyId)
            ->where('type_user', 'patient')
            ->with(['userDetail', 'patient']) // TANPA withTrashed
            ->get();

        // Exclude current user jika sedang update
        if ($this->data_id) {
            $users = $users->where('id', '!=', $this->data_id);
        }

        foreach ($users as $user) {
            if (! $user->userDetail || ! $user->userDetail->identity_card) {
                continue;
            }

            try {
                $decryptedIdentityCard = Crypt::decryptString(
                    $user->userDetail->identity_card
                );

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
                            'is_soft_deleted' => ! is_null($user->deleted_at),
                        ]);

                        $fail($errorMessage);

                        return;
                    }
                }
            } catch (\Exception $e) {
                // Skip jika gagal decrypt
                continue;
            }
        }
    }

    /**
     * Cek apakah ada perbedaan signifikan antara data current dengan existing user
     * Return TRUE jika ada perbedaan (diizinkan untuk menggunakan phone/email yang sama)
     * Return FALSE jika tidak ada perbedaan (tidak diizinkan)
     */
    protected function hasSignificantDifference($existingUser, $currentCompanyId)
    {
        // 1. Cek company_id
        if ($existingUser->company_id !== $currentCompanyId) {
            Log::info('Company difference detected', [
                'current' => $currentCompanyId,
                'existing' => $existingUser->company_id,
            ]);

            return true; // Company berbeda = ada perbedaan = diizinkan
        }

        // 2. Cek nama
        $nameMatch = strtolower(trim($this->name)) === strtolower(trim($existingUser->name));
        if (! $nameMatch) {
            Log::info('Name difference detected', [
                'current' => $this->name,
                'existing' => $existingUser->name,
            ]);

            return true; // Nama berbeda = ada perbedaan = diizinkan
        }

        // 3. Cek NIK (identity_card dari UserDetail)
        if ($existingUser->userDetail && $existingUser->userDetail->identity_card && $this->identity_card) {
            try {
                $existingIdentityCard = Crypt::decryptString($existingUser->userDetail->identity_card);
                $identityCardMatch = $existingIdentityCard === $this->identity_card;
                if (! $identityCardMatch) {
                    Log::info('NIK difference detected', [
                        'current_masked' => substr($this->identity_card, 0, 4).'****'.substr($this->identity_card, -4),
                        'existing_masked' => substr($existingIdentityCard, 0, 4).'****'.substr($existingIdentityCard, -4),
                    ]);

                    return true; // NIK berbeda = ada perbedaan = diizinkan
                }
            } catch (\Exception $e) {
                Log::info('NIK comparison failed (treating as different)', [
                    'error' => $e->getMessage(),
                ]);

                return true; // Tidak bisa decrypt = anggap berbeda = diizinkan
            }
        } else {
            Log::info('NIK not available for comparison (treating as different)', [
                'current_has_nik' => ! empty($this->identity_card),
                'existing_has_nik' => $existingUser->userDetail && $existingUser->userDetail->identity_card,
            ]);

            return true; // NIK tidak tersedia = anggap berbeda = diizinkan
        }

        // 4. Cek status identity_card_mother (dari model Patient)
        $existingPatient = $existingUser->patient;
        $existingIdentityCardMother = $existingPatient ? $existingPatient->identity_card_mother : false;
        $identityCardMotherMatch = $existingIdentityCardMother === $this->identity_card_mother;
        if (! $identityCardMotherMatch) {
            Log::info('Identity card mother status difference detected', [
                'current' => $this->identity_card_mother ? 'mother' : 'self',
                'existing' => $existingIdentityCardMother ? 'mother' : 'self',
            ]);

            return true; // Status berbeda = ada perbedaan = diizinkan
        }

        // Jika semua sama, tidak ada perbedaan signifikan
        Log::info('No significant difference found', [
            'name_match' => $nameMatch,
            'identity_card_mother_match' => $identityCardMotherMatch,
            'company_match' => true,
        ]);

        return false;
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

        // if ($user->company_id !== $companyId) {
        //     throw new \Exception('Patient tidak dalam company yang sama');
        // }

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
            'identity_card' => $this->identity_card,
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

        // Update Patient record jika sudah ada, jika tidak ada maka lewati
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
     * Check if should create transaction
     */
    protected function shouldCreateTransaction()
    {
        return ! empty($this->location_id) && ! empty($this->doctor_id) && ! empty($this->control_doctor_id) && ! empty($this->date);
    }

    /**
     * Create patient transaction
     */
    protected function createPatientTransaction($location, $doctor, $user, $companyId)
    {
        try {
            $branch = Branch::where('company_id', $companyId)->first();

            $patientRole = Role::where('name', 'Pasien')->first();
            $patientCompanyRole = UserCompanyRole::where('user_id', $user->id)
                ->where('company_id', $companyId)
                ->where('role_id', $patientRole->uuid)
                ->first();

            $lastTransaction = Transaction::withTrashed() // penting, cek termasuk yang soft delete
                ->whereDate('created_at', now())
                ->orderByDesc('code')
                ->lockForUpdate()
                ->first();

            $lastNumber = $lastTransaction
                ? (int) substr($lastTransaction->code, -4)
                : 0;

            $newNumber = $lastNumber + 1;

            $code = 'TRX'.now()->format('ymd').str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // double check sebelum create (antisipasi softDeletes & race condition)
            while (Transaction::withTrashed()->where('code', $code)->exists()) {
                $newNumber++;
                $code = 'TRX'.now()->format('ymd').str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            }

            // Generate consultation code
            $locationCode = strtoupper(implode('', array_map(fn ($word) => $word[0], explode(' ', $location->name))));
            $todayCount = Transaction::where('location_id', $this->location_id)
                ->where('doctor_id', $this->doctor_id)
                ->where('control_doctor_id', $this->control_doctor_id)
                ->whereDate('date', $this->date)
                ->count() + 1;

            $codeConsultation = $locationCode.str_pad($todayCount, 4, '0', STR_PAD_LEFT);
            // Create transaction
            $transactionData = [
                'code' => $code.rand(100, 999),
                'code_consultation' => $codeConsultation,
                'doctor_id' => $this->doctor_id,
                'doctor_name' => $doctor->name,
                'doctor_referral_id' => $this->doctor_referral_id,
                'location_id' => $this->location_id,
                'location_name' => $location->name,
                'control_doctor_id' => $this->control_doctor_id,
                'patient_id' => $user->id,
                'insurance_id' => $this->insurance_id,
                'insurance_number' => $this->insurance_number,
                'patient_name' => $user->name,
                'patient_company_role_id' => $patientCompanyRole?->id,
                'user_type_id' => $user->user_type_id,
                'deposit_id' => $this->selectedDepositId, // Add deposit_id
                'date' => $this->date,
                'days' => $this->days ?? date('l', strtotime($this->date)),
                'branch_id' => $branch?->id,
                'type_customer' => $this->data_id ? 'member' : 'new',
                'type_doctor' => $this->data_id ? 'old' : 'new',
                'type' => 'konsultasi',
                'status' => 'draft_consultation',
                'consultation' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
                'user_control_schedule_id' => $this->user_control_schedule_id ?? null,
                'is_insurance' => $this->is_insurance ? true : false,
            ];

            $transaction = Transaction::create($transactionData);

            UserControlSchedule::where('id', $this->user_control_schedule_id)
                ->update(['status' => 'completed', 'transaction_arrival_id' => $transaction->id]);

            // Use deposit quantity if selected and create TransactionDetails from DepositItems
            if ($this->selectedDepositId) {
                $this->useDepositQuantity($this->selectedDepositId, 1);
                $this->createTransactionDetailsFromDeposit($transaction->id, $this->selectedDepositId);
            } else {
                // Create consultation fee if no deposit is used
                $product = Product::where('name', 'Biaya Konsultasi')
                    ->where('company_id', $companyId)
                    ->first();

                $userPrice = UserPrice::where('user_id', $this->doctor_id)
                    ->first();

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => $this->doctor_id,
                    'product_id' => $product?->id ?? null,
                    'quantity' => 1,
                    'name' => 'Biaya Konsultasi',
                    'price' => $userPrice?->price_doctor ?? 0,
                    'price_hpp' => 0,
                    'sub_total_price' => $userPrice?->price_doctor ?? 0,
                    'sub_total_price_hpp' => 0,
                    'type_transaction' => 'other',
                ]);
            }

            $patient = Patient::where('user_id', $transaction->patient_id)->select('id')->first();
            $doctor = Practitioner::where('user_id', $transaction->doctor_id)->select('id')->first();

            $data = [
                'pending' => true,
                'id' => null,
                'transaction_id' => $transaction->id,
                'company_id' => $transaction->company_id,
                'location_id' => $transaction->location_id,
                'patient_id' => $patient->id ?? null,
                'practitioner_id' => $doctor->id ?? null,
                'type' => 'outpatient',
                'status' => 'planned',
                'class_code' => 'AMB',
            ];

            app(apiservice::class)->createTransaction($data);

            $encounter = Encounter::where('transaction_id', $transaction->id)->first();

            $data = [
                'pending' => true,
                'id' => $encounter->id ?? null,
                'transaction_id' => $transaction->id,
                'company_id' => $transaction->company_id,
                'location_id' => $transaction->location_id,
                'patient_id' => $patient->id ?? null,
                'practitioner_id' => $doctor->id ?? null,
                'type' => 'outpatient',
                'status' => 'arrived',
                'class_code' => 'AMB',
            ];

            app(apiservice::class)->createTransaction($data);

            Log::info('Patient transaction created', [
                'transaction_id' => $transaction->id,
                'transaction_code' => $transaction->code,
                'patient_id' => $user->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating patient transaction', [
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
            'email' => $this->findPatientConflictsInCompany('email', $this->email, $currentCompanyId, $this->data_id),
            'phone' => $this->findPatientConflictsInCompany('phone', $this->phone, $currentCompanyId, $this->data_id),
            // 'username' => $this->findPatientConflictsInCompany('username', $this->username, $currentCompanyId, $this->data_id)
        ];

        Log::info('Patient validation debug', [
            'conflicts' => $conflicts,
            'current_data' => $this->getPatientData(),
        ]);

        return $conflicts;
    }

    /**
     * Find conflicts specifically for patients in company
     */
    protected function findPatientConflictsInCompany($field, $value, $companyId, $excludeUserId = null)
    {
        $conflicts = [];

        $query = User::where($field, $value)
            ->where('type_user', 'patient')
            ->where('company_id', $companyId);

        if ($excludeUserId) {
            $query->where('id', '!=', $excludeUserId);
        }

        $patients = $query->get();

        foreach ($patients as $patient) {
            $conflicts[] = [
                'type' => 'patient_conflict',
                'user_id' => $patient->id,
                'user_name' => $patient->name,
                'field' => $field,
                'value' => $value,
                'context' => 'Patient dalam company yang sama',
            ];
        }

        return $conflicts;
    }

    public function render()
    {
        $companyId = Auth::user()->company_id;

        $patients = User::query()
            ->with(['userDetail', 'patient.OHPatient'])
            ->search($this->search)
            ->role('Pasien')
            ->CompanyChoice($companyId);

        if ($this->filterBirthDate) {
            $patients->whereHas('userDetail', function ($q) {
                $q->whereDate('birth_date', $this->filterBirthDate);
            });
        }

        $users = User::query()
            ->with(['userDetail', 'patient.OHPatient'])
            ->where('id', '!=', $this->data_id)
            ->search($this->searchUser)
            ->role('Pasien')
            ->CompanyChoice($companyId)
            ->paginate($this->perPagePatient, ['*'], 'pagePatient');

        return view('livewire.admin.consultation.patient.admin-consultation-patient-index', [
            'patients' => $patients->paginate($this->perPage),
            'users' => $users,
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

    /**
     * Use deposit quantity when consultation is created
     */
    public function useDepositQuantity($depositId, $quantity = 1)
    {
        try {
            $deposit = Deposit::find($depositId);
            if ($deposit && $deposit->remaining_quantity >= $quantity) {
                $deposit->decrement('remaining_quantity', $quantity);
                Log::info('Deposit quantity used', [
                    'deposit_id' => $depositId,
                    'quantity_used' => $quantity,
                    'remaining_quantity' => $deposit->fresh()->remaining_quantity,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error using deposit quantity', [
                'deposit_id' => $depositId,
                'quantity' => $quantity,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Create TransactionDetails from DepositItems
     */
    public function createTransactionDetailsFromDeposit($transactionId, $depositId)
    {
        try {
            // Get DepositItems dari deposit
            $depositItems = DepositItem::where('deposit_id', $depositId)->get();

            if ($depositItems->count() === 0) {
                Log::warning('No deposit items found', ['deposit_id' => $depositId]);

                return;
            }

            foreach ($depositItems as $depositItem) {
                // Pastikan quantity tidak null, tidak 0, dan berupa integer
                $originalQuantity = $depositItem->quantity;

                // Konversi quantity dengan berbagai kemungkinan format
                if (is_string($originalQuantity)) {
                    // Hapus format separators jika ada (titik, koma, dll)
                    $cleanQuantity = preg_replace('/[^0-9]/', '', $originalQuantity);
                    $quantity = intval($cleanQuantity);
                } else {
                    $quantity = intval($originalQuantity);
                }

                // Pastikan quantity minimal 1
                $quantity = max(1, $quantity);

                // Siapkan data TransactionDetail
                $transactionDetailData = [
                    'transaction_id' => $transactionId,
                    'product_id' => $depositItem->product_id,
                    'product_package_id' => $depositItem->product_package_id,
                    'name' => $depositItem->name,
                    'quantity' => $quantity,
                    'price' => $depositItem->price,
                    'discount' => $depositItem->discount ?? 0,
                    'sub_total_price' => $depositItem->sub_total_price,
                    'sub_total_price_hpp' => $depositItem->sub_total_price_hpp ?? 0,
                    'price_hpp' => $depositItem->price_hpp ?? 0,
                    'type_transaction' => $depositItem->type_transaction,
                    'type' => $depositItem->type,
                    'is_free' => $depositItem->is_free_item ?? false,
                    'is_narcotic' => $depositItem->is_narcotic ?? false,
                    'dosage_doctor' => $depositItem->dosage_doctor ?? 0,
                    'doctor_dosage_gram' => $depositItem->doctor_dosage_gram ?? 0,
                    'dosage_drug' => $depositItem->dosage_drug ?? 0,
                    'company_id' => Auth::user()->company_id,
                ];

                // Create TransactionDetail
                $transactionDetail = TransactionDetail::create($transactionDetailData);

                // Log untuk memverifikasi TransactionDetail yang berhasil dibuat
                Log::info('TransactionDetail created successfully', [
                    'transaction_detail_id' => $transactionDetail->id,
                    'input_quantity' => $quantity,
                    'saved_quantity' => $transactionDetail->quantity,
                    'fresh_quantity' => $transactionDetail->fresh()->quantity,
                    'name' => $transactionDetail->name,
                    'deposit_item_original' => $originalQuantity,
                ]);
            }

            Log::info('TransactionDetails created from deposit', [
                'transaction_id' => $transactionId,
                'deposit_id' => $depositId,
                'items_count' => $depositItems->count(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating TransactionDetails from deposit', [
                'transaction_id' => $transactionId,
                'deposit_id' => $depositId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Return deposit quantity when consultation is cancelled
     */
    public function returnDepositQuantity($depositId, $quantity = 1)
    {
        try {
            $deposit = Deposit::find($depositId);
            if ($deposit) {
                $deposit->increment('remaining_quantity', $quantity);
                Log::info('Deposit quantity returned', [
                    'deposit_id' => $depositId,
                    'quantity_returned' => $quantity,
                    'remaining_quantity' => $deposit->fresh()->remaining_quantity,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error returning deposit quantity', [
                'deposit_id' => $depositId,
                'quantity' => $quantity,
                'error' => $e->getMessage(),
            ]);
        }
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
