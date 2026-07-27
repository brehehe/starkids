<?php

namespace App\Livewire\Queue;

use App\Helpers\AlertHelper;
use App\Helpers\RoleHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Encounter\Encounter;
use App\Models\Location\Location;
use App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender;
use App\Models\Master\CodeSystem\Patient\MasterPatientMaritalStatus;
use App\Models\Patient\OneHealth\OneHealthPatient;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
use App\Models\Role\RoleCompany;
use App\Models\Spatie\Role;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\User;
use App\Models\User\ControlDoctor;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserDetail;
use App\Models\User\UserPrice;
use App\Models\User\UserType;
use App\service\apiservice;
use App\Traits\Region\RegionTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Throwable;

class QueueRegister extends Component
{
    use RegionTrait;

    public $step = 1;

    public $progress_bar = 20;

    public $open_form = true;

    public $company_items = [];

    public $poli_items = [];

    public $doctors = [];

    public $time_slots = [];

    public $company;

    public $poli;

    public $selected_doctor;

    public $visit_date;

    public $days;

    public $selected_time;

    // array for patient
    public $maritalStatusDetails = [];

    public $administrativeGenderDetails = [];

    public $provinces = [];

    public $cities = [];

    public $districts = [];

    public $subDistricts = [];

    // patient
    public $data_id;

    public $user_id;

    public $name;

    public $identity_card;

    public $identity_card_mother = false;

    public $email;

    public $phone;

    public $province_code;

    public $city_code;

    public $district_code;

    public $sub_district_code;

    public $address;

    public $postal_code;

    public $rt_code;

    public $rw_code;

    public $blood_group;

    public $marital_status;

    public $birth_date;

    public $patient_complaint;

    public $administrative_gender;

    public $user_type_id;

    public function render()
    {
        return view('livewire.queue.queue-register')->extends('layout.queue.app');
    }

    public function mount()
    {
        $this->open_form = true;
        // $this->progress_bar = 100 / $this->step;
        // dd(Request::root() == 'http://127.0.0.1:8000');
        if (Request::root() == 'http://127.0.0.1:8000') {
            $this->company_items = Company::orderBy('order', 'ASC')->first()->companies()->select('id', 'name')->get();
        }
        // $this->company_items = Company::orderBy('order', 'ASC')->first()->companies()->select('id', 'name')->get();
        $this->company_items = Company::select('id', 'name')->get();

        $this->provinces = $this->getProvinceTrait();
        $this->administrativeGenderDetails = MasterPatientAdministrativeGender::select('code', 'display')
            ->whereIn('code', ['male', 'female'])
            ->get()
            ->toArray();
        $this->maritalStatusDetails = MasterPatientMaritalStatus::select('code', 'display')->get()->map(function ($item) {
            return [
                'code' => $item->code,
                'display' => $item->display,             // versi asli
                'display_ind' => $item->display_ind,     // otomatis dari accessor
            ];
        });

        $this->user_type_id = UserType::where('company_id', Company::orderBy('order', 'ASC')->first()?->id)->where('name', 'Umum')->first()?->id;
        // dd($this->user_type_id);
    }

    public function updated()
    {
        if ($this->company) {
            $this->poli_items = Location::where('company_id', $this->company)->select('id', 'name', 'description')->get();
            $this->doctors = User::where('type_user', 'employee')
                ->orderBy('name', 'asc')->get();
            // dd($this->company, $this->doctors);
        }

        if ($this->poli) {
            // $this->reset('selected_doctor', 'visit_date', 'day', 'time_slots');
            $this->doctors = User::role('Dokter')->where('type_user', 'employee')->orderBy('name', 'asc')->get();
        }

        if ($this->selected_doctor) {
            $this->time_slots = [];
            // $this->getControlDoctors();
        }

        if ($this->visit_date) {
            $this->time_slots = [];
            $this->getControlDoctors();
        }
    }

    public function nextStep()
    {
        $this->step += 1;
        $this->progress_bar += 20;
    }

    public function prevStep()
    {
        $this->step -= 1;
        $this->progress_bar -= 20;
    }

    public function getControlDoctors()
    {
        $this->time_slots = [];
        if ($this->poli && $this->selected_doctor && $this->visit_date) {
            $days = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];

            $englishDay = date('l', strtotime($this->visit_date));
            $this->days = $days[$englishDay];

            $this->time_slots = ControlDoctor::where('location_id', $this->poli)
                ->where('user_id', $this->selected_doctor)
                ->where(function ($query) {
                    // Check if days JSONB contains the current day OR is unlimited
                    $query->where(function ($subQuery) {
                        $subQuery->whereJsonContains('days', $this->days);
                    })->orWhere('is_unlimited', true);
                })
                ->get()
                ->filter(function ($item) {
                    // For unlimited doctors, still check if the day is valid (unless truly unlimited for all days)
                    if ($item->is_unlimited) {
                        // If unlimited but days is specified, still check days
                        if ($item->days && is_array(json_decode($item->days, true))) {
                            $validDays = json_decode($item->days, true);
                            if (! in_array($this->days, $validDays)) {
                                return false; // Day not in allowed days
                            }
                        }

                        return true; // Unlimited and day is valid
                    }

                    // For regular doctors, check both days and quota
                    $validDays = json_decode($item->days, true);
                    if (! $validDays || ! in_array($this->days, $validDays)) {
                        return false; // Day not in allowed days
                    }

                    $count = Transaction::where('control_doctor_id', $item->id)
                        ->where('location_id', $this->poli)
                        ->where('doctor_id', $this->selected_doctor)
                        ->whereDate('date', $this->visit_date)
                        ->count();

                    return $count < $item->max_patients;
                })
                ->map(function ($item) {
                    // Hitung jumlah pasien terdaftar pada tanggal yang dipilih untuk dokter kontrol ini
                    $countTransactions = Transaction::where('control_doctor_id', $item->id)
                        ->where('location_id', $this->poli)
                        ->where('doctor_id', $this->selected_doctor)
                        ->whereDate('date', $this->visit_date)
                        ->count();

                    // Handle unlimited doctors
                    $maxPatients = $item->is_unlimited ? '♾️' : $item->max_patients;
                    $remainingQuota = $item->is_unlimited ? null : ($item->max_patients - $countTransactions);
                    $isFull = $item->is_unlimited ? false : ($countTransactions >= $item->max_patients);

                    return [
                        'id' => $item->id,
                        'days' => $item->days, // Return JSONB days (corrected from $item->day)
                        'day' => $this->days, // Current selected day
                        'start_time' => $item->start_time->format('H:i'),
                        'end_time' => $item->end_time->format('H:i'),
                        'max_patients' => $maxPatients,
                        'current_patients' => $countTransactions,
                        'remaining_quota' => $remainingQuota,
                        'is_full' => $isFull,
                        'is_unlimited' => $item->is_unlimited,
                    ];
                })
                ->toArray();
        } else {
            $this->time_slots = [];
        }

        // dd($this->time_slots, $this->poli, $this->selected_doctor, $this->visit_date);
    }

    public function formAddPatient()
    {
        if ($this->open_form == false) {
            $this->open_form = true;
        } else {
            $this->open_form = false;
        }
    }

    // form patient
    public function updatedProvinceCode()
    {
        $this->cities = $this->getCityTrait($this->province_code);
        $this->reset(['city_code', 'district_code', 'sub_district_code', 'districts', 'subDistricts']);
    }

    public function updatedCityCode()
    {
        $this->districts = $this->getDistrictTrait($this->city_code);
        $this->reset(['district_code', 'sub_district_code', 'subDistricts']);
    }

    public function updatedDistrictCode()
    {
        $this->subDistricts = $this->getSubDistrictTrait($this->district_code);
        $this->reset('sub_district_code');
    }

    public function regisQueue()
    {
        // dd('sdsdsd');
        $this->validate(
            [
                'name' => 'required|string|max:255',
                'identity_card' => [
                    'required',
                    'string',
                    'digits:16',
                    'regex:/^[0-9]{16}$/',
                ],
                'email' => [
                    'nullable', // Allow null for email
                    'email',
                    'max:255',
                    // function ($attribute, $value, $fail) use ($currentCompanyId) {
                    //     $this->validateUniquePatientInCompany('email', $value, $currentCompanyId, $fail);
                    // },
                ],
                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^[0-9+\-\s\(\)]*$/', // hanya angka, +, -, spasi, dan kurung
                    // Temporarily disabled to debug
                    // function ($attribute, $value, $fail) use ($currentCompanyId) {
                    //     $this->validateUniquePatientInCompany('phone', $value, $currentCompanyId, $fail);
                    // },
                ],
                'address' => 'nullable|string|max:500',
                'postal_code' => 'nullable|string|max:20',
                'blood_group' => 'nullable|string|max:10',
                'administrative_gender' => 'required|in:male,female',
                'birth_date' => 'nullable|date|before:today',
                'marital_status' => 'nullable',
                'province_code' => 'nullable',
                'city_code' => 'nullable',
                'district_code' => 'nullable',
                'sub_district_code' => 'nullable',
                'rt_code' => 'nullable',
                'rw_code' => 'nullable',
                // 'location_id'           => 'required|exists:locations,id',
                // 'doctor_id'             => 'required|exists:users,id',
                // 'control_doctor_id'     => 'required|exists:control_doctors,id',
                // 'user_type_id'          => 'required|exists:user_types,id',
            ],
            [
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
                'location_id.required' => 'Poli wajib dipilih',
                'doctor_id.required' => 'Dokter wajib dipilih',
                'control_doctor_id.required' => 'Control doctor wajib dipilih',
                'province_code' => 'Provinsi wajib diisi',
                'city_code' => 'Kota/kabupaten wajib diisi',
                'district_code' => 'Kecamatan wajib diisi',
                'sub_district_code' => 'Kelurahan wajib diisi',
                'rt_code.required' => 'RT wajib diisi',
                'rw_code.required' => 'RW wajib diisi',
                'user_type_id.required' => 'Tipe pasien wajib dipilih',
            ]
        );

        // $currentCompanyId = Company::orderBy('order', 'ASC')->first()?->id;
        $currentCompanyId = Company::firstWhere('id', $this->company)?->id;

        try {
            DB::beginTransaction();
            $location = Location::findOrFail($this->poli);
            $doctor = User::findOrFail($this->selected_doctor);

            $userResult = $this->handlePatientIdentityResolution($currentCompanyId);

            if (! $userResult['success']) {
                Log::error('Failed to handle patient identity: '.$userResult['message']);
                throw new Exception('Failed to handle patient identity: '.$userResult['message']);
            }

            $user = $userResult['user'];
            Log::info('Patient handled successfully', ['user_id' => $user->id]);

            Log::info('Updating user detail...');
            $this->updateUserDetail($user);

            $patient = Patient::where('user_id', $user->id)->first();

            $oneHealthPatient = OneHealthPatient::where('patient_id', $patient?->id)->first();
            if (! $patient || ! $oneHealthPatient || ! $oneHealthPatient->id_patient) {
                Log::info('Creating user via API service...');
                app(apiservice::class)->createUser($user);
            }

            // Assign patient role
            Log::info('Assigning patient role...');
            $this->assignPatientRole($user, $currentCompanyId);

            if ($this->shouldCreateTransaction()) {
                Log::info('Creating patient transaction...');

                $this->createPatientTransaction($location, $doctor, $user, $currentCompanyId);
            }

            DB::commit();
        } catch (Exception|Throwable $th) {
            DB::rollBack();
            $errors = [
                'message' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
            ];
            Log::error('Ada kesalahan saat daftyar antrian', $errors);

            return AlertHelper::error('Gagal', $th->getMessage());
        }

        AlertHelper::success('Berhasil', 'Patient berhasil ditambahkan.');

        // $this->emit('patientSaved');
        // Log::info('Patient successfully saved', ['user_id' => $user->id]);

        return redirect()->route('queue');
    }

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
        } catch (Exception $e) {
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
                throw new Exception('Role Pasien tidak ditemukan');
            }

            $roleCompany = RoleCompany::where('company_id', $companyId)
                ->where('role_id', $role->uuid)
                ->first();

            if (! $roleCompany) {
                $roleCompany = RoleCompany::create([
                    'role_id' => $role->uuid,
                    'company_id' => $companyId,
                ]);
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
        } catch (Exception $e) {
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
        return ! empty($this->poli) && ! empty($this->selected_doctor) && ! empty($this->selected_time) && ! empty($this->visit_date);
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

            // Generate transaction code
            $transactionCode = 'TRX'.date('ymd').str_pad(
                Transaction::whereDate('created_at', Carbon::now())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            // Generate consultation code
            $locationCode = strtoupper(implode('', array_map(fn ($word) => $word[0], explode(' ', $location->name))));
            $todayCount = Transaction::where('location_id', $this->poli)
                ->where('doctor_id', $this->selected_doctor)
                ->where('control_doctor_id', $this->selected_time)
                ->whereDate('date', $this->visit_date)
                ->count() + 1;

            $codeConsultation = $locationCode.str_pad($todayCount, 4, '0', STR_PAD_LEFT);
            // Create transaction
            $transactionData = [
                'code' => $transactionCode,
                'code_consultation' => $codeConsultation,
                'doctor_id' => $this->selected_doctor,
                'doctor_name' => $doctor->name,
                'location_id' => $this->poli,
                'location_name' => $location->name,
                'control_doctor_id' => $this->selected_time,
                'patient_id' => $user->id,
                'patient_name' => $user->name,
                'patient_company_role_id' => $patientCompanyRole?->id,
                'user_type_id' => $user->user_type_id,
                'date' => $this->visit_date,
                'days' => $this->days ?? date('l', strtotime($this->visit_date)),
                'branch_id' => $branch?->id,
                'type_customer' => $this->data_id ? 'member' : 'new',
                'type_doctor' => $this->data_id ? 'old' : 'new',
                'type' => 'konsultasi',
                'status' => 'waiting_consultation',
                'consultation' => 'yes',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $transaction = Transaction::create($transactionData);

            $userPrice = UserPrice::where('user_id', $this->selected_doctor)
                ->where('company_id', $companyId)
                ->first();

            if ($userPrice) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => $this->selected_doctor,
                    'quantity' => 1,
                    'name' => 'Biaya Konsultasi',
                    'price' => $userPrice->price_doctor,
                    'price_hpp' => 0,
                    'sub_total_price' => $userPrice->price_doctor,
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
                'transaction_code' => $transactionCode,
                'patient_id' => $user->id,
            ]);
        } catch (Exception $e) {
            Log::error('Error creating patient transaction', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
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
}
