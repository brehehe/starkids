<?php

namespace App\Livewire\Mobile\QueueRegister;

use App\Helpers\AlertHelper;
use App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender;
use App\Models\Master\CodeSystem\Patient\MasterPatientMaritalStatus;
use App\Models\User;
use App\Models\User\UserType;
use App\Services\Mobile\Patient\PatientService;
use App\Traits\OneHealth\AuthenticateTrait;
use App\Traits\Region\RegionTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class QueueRegisterCreatePatient extends Component
{
    use AuthenticateTrait, RegionTrait;

    protected PatientService $patientService;

    // Array
    public $provinces = [];

    public $cities = [];

    public $districts = [];

    public $subDistricts = [];

    public $maritalStatusDetails = [];

    public $administrativeGenderDetails = [];

    // Data
    public bool $identity_card_mother = false; // default: NIK (OFF)

    public $name;

    public $identity_card;

    public $email;

    public $phone;

    public $birth_date;

    public $age;

    public $family_status;

    public $marital_status;

    public $administrative_gender;

    public $blood_group;

    public $province_code;

    public $city_code;

    public $district_code;

    public $sub_district_code;

    public $address;

    public $postal_code;

    public $rt_code;

    public $rw_code;

    public function render()
    {
        return view('livewire.mobile.queue-register.queue-register-create-patient')->layout('layout.mobile.app-mobile', [
            'activeTab' => 'queue-register-create-patient',
            'title' => 'Queue',
            'showHeader' => false,
            'showBottom' => false,
        ]);
    }

    public function mount()
    {
        $this->provinces = [];
        $this->provinces = $this->getProvinceTrait();

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
    }

    public function boot(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function updatedUseMotherNik($value): void
    {
        $this->identity_card = null;
    }

    public function updatedProvinceCode()
    {
        $this->city_code = null;
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

    public function submit()
    {
        $currentCompanyId = Auth::user()->company_id;
        $this->validate(
            [
                'name' => 'required|string|max:255',
                'identity_card' => [
                    'required',
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
                            // Log::warning("Skipping phone validation - no current company ID");
                        }
                    },
                ],
                'province_code' => 'required|string|max:500',
                'city_code' => 'required|string|max:500',
                'district_code' => 'required|string|max:500',
                'sub_district_code' => 'required|string|max:500',
                'address' => 'required|string|max:500',
                'postal_code' => 'required|string|max:20',
                'blood_group' => 'nullable|string|max:10',
                'administrative_gender' => 'required|in:male,female',
                'birth_date' => 'required|date|before:today',
                'family_status' => 'required|string',
                'marital_status' => 'nullable',
                'rt_code' => 'required',
                'rw_code' => 'required',
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'identity_card.required' => 'NIK wajib diisi',
                'identity_card.digits' => 'NIK harus terdiri dari 16 digit',
                'identity_card.regex' => 'NIK hanya boleh berisi angka',
                'email.email' => 'Format email tidak valid',
                'phone.required' => 'Nomor telepon wajib diisi',
                'phone.regex' => 'Format nomor telepon tidak valid',
                'province_code.required' => 'Provinsi wajib diisi',
                'city_code.required' => 'Kota/kabupaten wajib diisi',
                'district_code.required' => 'Kecamatan wajib diisi',
                'sub_district_code.required' => 'Kelurahan wajib diisi',
                'address.required' => 'Alamat wajib diisi',
                'administrative_gender.required' => 'Jenis kelamin wajib dipilih',
                'administrative_gender.in' => 'Jenis kelamin harus male atau female',
                'birth_date.required' => 'Tanggal lahir wajjib diisi',
                'birth_date.before' => 'Tanggal lahir harus sebelum hari ini',
                'family_status.required' => 'Status keluarga wajib diisi',
                'postal_code.required' => 'Kode pos wajib diisi',
                'marital_status.required' => 'Status pernikahan wajib dipilih',
                'location_id.required' => 'Poli wajib dipilih',
                'doctor_id.required' => 'Dokter wajib dipilih',
                'control_doctor_id.required' => 'Control doctor wajib dipilih',
                'rt_code.required' => 'RT wajib diisi',
                'rw_code.required' => 'RW wajib diisi',
            ]
        );

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

        try {
            DB::beginTransaction();
            $dataPatient = [
                'name' => $this->name,
                'identity_card' => $this->identity_card,
                'identity_card_mother' => $this->identity_card_mother,
                'email' => $this->email,
                'phone' => $this->phone,
                'user_id' => null,
                'user_type_id' => UserType::where('name', 'Umum')->first()?->id,
                'address' => $this->address,
                'blood_group' => $this->blood_group,
                'administrative_gender' => $this->administrative_gender,
                'birth_date' => $this->birth_date,
                'marital_status' => $this->marital_status,
                'province_code' => $this->province_code,
                'city_code' => $this->city_code,
                'district_code' => $this->district_code,
                'sub_district_code' => $this->sub_district_code,
                'rt_code' => $this->rt_code,
                'rw_code' => $this->rw_code,
                'postal_code' => $this->postal_code,
                'family_status' => $this->family_status,
            ];

            $patient = $this->patientService->updateCreatePatient($dataPatient, null);

            if (! $patient) {
                throw new Exception('error updateCreatePatient', 1);
            }

            $this->patientService->createFamilyMember(Auth::user(), $patient, null, $dataPatient);

            // $this->patientService->handlePatientAPIIntegration($patient, $dataPatient);

            DB::commit();
        } catch (Exception|Throwable $th) {
            DB::rollBack();
            $errors = [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ];

            Log::error('Ada kesalahan submit create patient', $errors);

            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat tambah pasien');
        }

        return redirect()->route('mobile.queue.register');
    }

    protected function validateUniqueIdentityCard($identityCard, $companyId, $fail)
    {
        if (empty($identityCard)) {
            return;
        }

        // Log::info("Validating identity card uniqueness", [
        //     'identity_card' => $identityCard,
        //     'company_id' => $companyId,
        //     'name' => $this->name,
        //     'identity_card_mother' => $this->identity_card_mother,
        //     'exclude_user_id' => $this->data_id
        // ]);

        // Cari semua user dengan NIK yang sama dalam company
        // ❌ Hapus ->withTrashed(), hanya validasi ke user aktif
        $query = User::whereHas('userDetail', function ($q) {
            // Filter dilakukan di loop karena perlu decrypt
        })
            ->where('company_id', $companyId)
            ->where('type_user', 'patient');

        // Exclude current user jika sedang update
        // if ($this->data_id) {
        //     $query->where('id', '!=', $this->data_id);
        // }

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

                        // Log::warning("Identity card validation failed", [
                        //     'identity_card' => $identityCard,
                        //     'name' => $this->name,
                        //     'identity_card_mother' => $this->identity_card_mother,
                        //     'existing_user_id' => $user->id,
                        //     'existing_user_name' => $user->name,
                        //     'existing_identity_card_mother' => $existingIdentityCardMother,
                        //     'conflict_type' => 'exact_duplicate'
                        // ]);

                        $fail($errorMessage);

                        return;
                    }

                    // NIK sama tapi kombinasi nama/status berbeda = diizinkan
                    // Log::info("Same NIK with different combination allowed", [
                    //     'identity_card' => $identityCard,
                    //     'current_name' => $this->name,
                    //     'current_identity_card_mother' => $this->identity_card_mother,
                    //     'existing_name' => $user->name,
                    //     'existing_identity_card_mother' => $existingIdentityCardMother,
                    //     'name_match' => $nameMatch,
                    //     'status_match' => $identityCardMotherMatch,
                    //     'context' => 'Different person/status using same NIK (allowed)'
                    // ]);
                }
            } catch (Exception $e) {
                Log::warning('Failed to decrypt identity card', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);

                continue;
            }
        }

        Log::info('Identity card validation passed');
    }

    protected function validateUniqueContactInfo($field, $value, $companyId, $fail)
    {
        if (empty($value)) {
            return;
        }

        // Log::info("Validating contact info uniqueness (skip soft deleted)", [
        //     'field' => $field,
        //     'value' => $value,
        //     'company_id' => $companyId,
        //     'name' => $this->name,
        //     'identity_card' => $this->identity_card,
        //     'identity_card_mother' => $this->identity_card_mother,
        //     'exclude_user_id' => $this->data_id
        // ]);

        $query = User::where($field, $value)
            ->where('type_user', 'patient'); // tidak pakai withTrashed()

        // if ($this->data_id) {
        //     $query->where('id', '!=', $this->data_id);
        // }

        $existingUsers = $query->with(['userDetail', 'patient'])->get();

        foreach ($existingUsers as $existingUser) {
            $hasAnyDifference = $this->hasAnyDifferenceInCriteria($existingUser);

            if ($hasAnyDifference) {
                // Log::info("Contact info ALLOWED - ada perbedaan kriteria", [
                //     'field' => $field,
                //     'value' => $value,
                //     'existing_user_id' => $existingUser->id,
                //     'different_criteria' => $this->findDifferentCriteria($existingUser)
                // ]);
                continue;
            }

            // Jika SEMUA kriteria sama → tolak (karena user aktif)
            $fieldName = $this->getFieldDisplayName($field);
            $existingIdentityInfo = $this->getExistingUserIdentityInfo($existingUser);

            $errorMessage = "{$fieldName} '{$value}' sudah digunakan oleh pasien lain dengan identitas yang sama persis: {$existingUser->name} {$existingIdentityInfo}";

            // Log::warning("Contact info validation FAILED - exact duplicate aktif", [
            //     'field' => $field,
            //     'value' => $value,
            //     'existing_user_id' => $existingUser->id,
            //     'reason' => 'All criteria sama persis pada user aktif'
            // ]);

            $fail($errorMessage);

            return;
        }

        Log::info("Contact info validation PASSED untuk field: {$field}");
    }
}
