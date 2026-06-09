<?php

namespace App\Livewire\Admin\Sale\Pos;

use App\Helpers\AlertHelper;
use App\Helpers\RoleHelper;
use App\Models\Cash\Cash;
use App\Models\Doctor\Doctor;
use App\Models\Location\Location;
use App\Models\Master\CodeSystem\Patient\MasterPatientAdministrativeGender;
use App\Models\Printer\Printer;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserDetail;
use App\Services\Promotion\PromotionQuantityService;
use Carbon\Carbon;
use Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AdminSalePosIndex extends Component
{
    use WithPagination;

    protected $queryString = [
        'page' => ['except' => 1], // Ini akan menghapus ?page=1 dari URL
        'patientPage' => ['except' => 1],
        'search' => ['except' => ''],
    ];

    public $page = 1;

    public $patientPage = 1;

    public $search;

    public $perPage = 5;

    public $status;

    public $date;

    public $type_transaction;

    public $patient_company_role_transaction_id;

    public $searchModalPatient;

    public $type;

    public $type_customer;

    public $patient_id;

    public $patient_company_role_id;

    public $patient_name;

    public $patient_address;

    public $patient_phone;

    public $patient_email;

    public $catatan;

    public $patient_gender;

    public $doctor_id;

    public $name_doctor;

    public $type_doctor;

    public $specialization;

    public $hospital;

    public $number_recipe;

    public $cashBank;

    public $amount;

    public $description;

    public $selectedPrinters = [];

    public $select_printer_id;

    public $paperWidth;

    public $cashDrawer;

    public function mount()
    {
        app(PromotionQuantityService::class)->recalculateAllDiscounts();

        $this->paperWidth = config('app.slug') == 'starkids' ? 64 : 48;
        $this->cashDrawer = config('app.slug') == 'starkids' ? false : true;

        // $cashBank = Cash::where('company_id', Auth::user()->company_id)
        //     ->where('user_id', Auth::user()->id)
        //     ->where('is_active', true);

        // if ($cashBank->exists() === false) {
        //     return $this->dispatch('open-modal', ['id' => 'modalCash']);
        // }

        // $this->cashBank = $cashBank->first();

        Session::forget('transaction_id');
        // $this->date = Carbon::now()->format('Y-m-d'); // Comment out default date filter

        // $response = Http::withOptions([
        //     'verify' => false, // 🚨 abaikan SSL check (dev only)
        // ])->get('https://127.0.0.1:5054/scan');

        // $this->selectedPrinters = $response->json()['printers'] ?? [];

        if (session()->has('saved')) {
            AlertHelper::success(session('saved.title'), session('saved.text'));
            session()->forget('saved');

            return;
        }
    }

    // public function updatedSelectPrinterId()
    // {
    //     if (!$this->select_printer_id) return;

    //     $printer = json_decode($this->select_printer_id, true);

    //     $payload = [
    //         'printer_name' => $printer['name'],
    //         'printer_type' => $printer['type'],
    //     ];

    //     // kalau bluetooth (SPP via COM) tambahkan addr atau COM port
    //     if ($printer['type'] === 'bluetooth' && isset($printer['addr'])) {
    //         $payload['addr'] = $printer['addr'];
    //     }
    //     if ($printer['type'] === 'com') {
    //         $payload['channel'] = $printer['name']; // contoh: COM5
    //     }

    //     $response = Http::withOptions([
    //         'verify' => false, // 🚨 abaikan SSL check (dev only)
    //     ])->post('https://127.0.0.1:5054/select', $payload);

    //     return AlertHelper::success('Berhasil', 'Printer berhasil dipilih.' . $response->body());
    // }

    // public function printInvoice()
    // {
    //     $payload = [
    //         'store_name' => 'Starkids Medical Center',
    //         'items' => [
    //             ['name' => 'Paracetamol', 'total' => '10.000'],
    //             ['name' => 'Vitamin C', 'total' => '15.000'],
    //         ],
    //         'total' => '25.000'
    //     ];

    //     $response = Http::withOptions([
    //         'verify' => false,
    //     ])->post('http://127.0.0.1:5054/print', $payload);

    //     $json = $response->json();

    //     // kalau tipe bluetooth-web, trigger ke JS
    //     if (($json['status'] ?? '') === 'success' && str_contains($json['message'], 'Web Bluetooth')) {
    //         $this->dispatchBrowserEvent('print-web-bluetooth', [
    //             'invoice' => "=== Starkids Medical Center ===\nParacetamol 10.000\nVitamin C 15.000\nTOTAL 25.000\n"
    //         ]);
    //     }

    //     return AlertHelper::success('Berhasil', 'Print status: ' . $response->body());
    // }

    public function submitCashBank()
    {
        $this->validate([
            'amount' => 'required',
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();

            Cash::updateOrCreate(
                [
                    'company_id' => Auth::user()->company_id,
                    'user_id' => Auth::user()->id,
                    'is_active' => true,
                ],
                [
                    'amount' => intval(Str::replace('.', '', $this->amount)),
                    'amount_real' => intval(Str::replace('.', '', $this->amount)),
                    'description' => $this->description,
                    'start_date' => Carbon::now(),
                    'end_date' => null,
                ]
            );

            DB::commit();

            session()->flash('saved', [
                'title' => 'Cash Bank Berhasil!',
                'text' => 'Anda berhasil membuat Cash Bank baru!',
            ]);

            $this->dispatch('close-modal', ['id' => 'modalCash']);

            return redirect()->route('user.sale.pos');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal membuat Cashbank: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat membuat Cashbank.');
        }
    }

    public function openModal()
    {
        $this->type = 'non-resep';

        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function changeType($type)
    {
        $this->type = $type;
        $this->reset('type_customer', 'patient_id', 'patient_company_role_id', 'patient_name', 'patient_address', 'patient_phone', 'patient_email', 'catatan', 'patient_gender', 'type', 'doctor_id', 'name_doctor', 'type_doctor', 'specialization', 'hospital');
    }

    public function updatedTypeCustomer()
    {
        $type = $this->type_customer;
        if ($type == 'umum') {
            $this->patient_name = 'Umum';
        } else {
            $this->patient_id = null;
            $this->patient_company_role_id = null;
            $this->patient_name = null;
            $this->patient_address = null;
            $this->patient_phone = null;
            $this->patient_gender = null;
        }
    }

    public function updatedPatientCompanyRoleId()
    {
        $patientCompany = UserCompanyRole::find($this->patient_company_role_id);
        if ($patientCompany) {
            $this->patient_id = $patientCompany->user->id;
            $this->patient_name = $patientCompany->user->name;
            $this->patient_address = $patientCompany->user->userDetail->address;
            $this->patient_phone = trim($patientCompany->user->phone);
            $this->patient_gender = $patientCompany->user->userDetail->administrative_gender;
        } else {
            $this->patient_id = null;
            $this->patient_name = null;
            $this->patient_address = null;
            $this->patient_phone = null;
            $this->patient_gender = null;
        }
    }

    public function updatedTypeDoctor()
    {
        $this->reset(['doctor_id', 'name_doctor', 'specialization', 'hospital']);
    }

    public function updatedDoctorId()
    {
        $doctor = Doctor::find($this->doctor_id);
        $this->name_doctor = $doctor ? $doctor->name : null;
        $this->specialization = $doctor ? $doctor->specialization : null;
        $this->hospital = $doctor ? $doctor->hospital : null;
    }

    public function closeModal()
    {
        $this->resetValidation();
        $this->reset(['type_customer', 'patient_id', 'patient_company_role_id', 'patient_name', 'patient_address', 'patient_phone', 'patient_email', 'catatan', 'patient_gender', 'type', 'doctor_id', 'name_doctor', 'type_doctor', 'specialization', 'hospital']);
        $this->dispatch('close-modal', ['id' => 'modal']);
    }

    public function saveTransaction()
    {
        $this->validate([
            'type_customer' => 'required',
            'patient_company_role_id' => $this->type_customer == 'member' ? 'required' : 'nullable',
            'patient_name' => $this->type_customer == 'umum' ? 'nullable' : 'required',
            'patient_address' => $this->type_customer == 'umum' ? 'nullable' : 'required',
            'patient_phone' => $this->type_customer == 'umum' ? 'nullable' : 'required',
            'number_recipe' => $this->type == 'resep' ? 'required' : 'nullable',
            'doctor_id' => $this->type == 'resep' ? ($this->type_doctor == 'old' ? 'required' : 'nullable') : 'nullable',
            'name_doctor' => $this->type == 'resep' ? 'required' : 'nullable',
        ]);

        try {
            DB::beginTransaction();

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

            $transaction = Transaction::create([
                'code' => $code,
                'type_customer' => $this->type_customer,
                'patient_name' => $this->patient_name,
                'type' => $this->type,
                'catatan' => $this->catatan,
                'status' => 'draft',
            ]);

            if ($this->type_customer == 'new') {
                $name = strtolower(str_replace(' ', '', $this->patient_name));
                $username = $name;
                $counter = 1;

                while (User::where('username', $username)->exists()) {
                    $username = $name.$counter;
                    $counter++;
                }

                $this->patient_phone = trim($this->patient_phone);

                $user = User::where('phone', $this->patient_phone)->orWhere('name', $this->patient_name)->first();

                if (! $user) {
                    $user = User::create([
                        'name' => $this->patient_name,
                        'username' => $username,
                        'phone' => $this->patient_phone,
                        'email' => $this->patient_email,
                        'password' => bcrypt('12345678'),
                    ]);
                }

                $patient = UserDetail::where('user_id', $user->id)->first();

                if (! $patient) {
                    $patient = UserDetail::create([
                        'user_id' => $user->id,
                        'address' => $this->patient_address,
                        'administrative_gender' => $this->patient_gender,
                    ]);
                }

                RoleHelper::assignRoleToUserInCompany($user, 'Pasien', Auth::user()->company_id, 'PMR'.date('ymd').str_pad(User::where('company_id', Auth::user()->company_id)->whereDate('created_at', Carbon::now())->count() + 1, 5, '0', STR_PAD_LEFT));

                $patient_company = UserCompanyRole::companyRole('Pasien', Auth::user()->company_id)->where('user_id', $user->id)->where('company_id', Auth::user()->company_id)->first();
            } else {
                $patient_company = UserCompanyRole::find($this->patient_company_role_id);
                $user = User::find($this->patient_id);
            }

            if ($this->type == 'resep') {
                if ($this->type_doctor == 'new') {
                    $doctor = Doctor::create([
                        'name' => $this->name_doctor,
                        'type' => 'external',
                        'specialization' => $this->specialization,
                        'hospital' => $this->hospital,
                        'company_id' => Auth::user()->company_id,
                    ]);

                    $transaction->doctor_id = $doctor->id;
                    $transaction->doctor_name = $doctor->name;
                } else {
                    $transaction->doctor_id = $this->doctor_id;
                    $transaction->doctor_name = $this->name_doctor;
                }
                $transaction->number_recipe = $this->number_recipe;
            } else {
                $transaction->doctor_id = null;
                $transaction->doctor_name = null;
                $transaction->number_recipe = null;
            }

            Session::put('transaction_id', $transaction->id);

            $location = Location::where('name', 'Instalasi Farmasi')->where('company_id', Auth::user()->company_id)->first();

            $locationCode = strtoupper(implode('', array_map(fn ($word) => $word[0], explode(' ', $location->name))));
            $todayCount = Transaction::where('location_id', $location->id)
                ->whereDate('date', Carbon::now())
                ->count() + 1;

            $codeConsultation = $locationCode.str_pad($todayCount, 4, '0', STR_PAD_LEFT);

            $transaction->location_id = $location->id;
            $transaction->location_name = $location->name;
            $transaction->code_consultation = $codeConsultation;
            $transaction->patient_name = $user ? $user->name : $this->patient_name;
            $transaction->patient_id = $user ? $user->id : $this->patient_id;
            $transaction->patient_company_role_id = $patient_company ? $patient_company->id : $this->patient_company_role_id;
            $transaction->save();

            DB::commit();

            session()->flash('saved', [
                'title' => 'Transaksi Berhasil!',
                'text' => 'Anda berhasil membuat transaksi baru!',
            ]);

            $this->closeModal();

            if ($transaction->type == 'resep') {
                return redirect()->route('user.sale.pos.recipe');
            } else {
                return redirect()->route('user.sale.pos.detail');
            }
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal membuat transaksi: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat membuat transaksi.');
        }
    }

    public function openDetail($id)
    {
        Session::put('transaction_id', $id);
        $transaction = Transaction::find($id);

        if (in_array($transaction->type, ['resep', 'konsultasi'])) {
            return redirect()->route('user.sale.pos.recipe');
        } else {
            return redirect()->route('user.sale.pos.detail');
        }
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus transaksi ini?', $id);
    }

    public function confirmDeleteTransaction($id)
    {
        return AlertHelper::confirmDelete('deleteTransaction', 'Apakah Anda yakin ingin menghapus transaksi ini?', $id);
    }

    public function delete($data)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::find($data[0]);
            if ($transaction) {
                $transaction->delete();
                DB::commit();

                return AlertHelper::success('Berhasil', 'Transaksi berhasil dihapus.');
            } else {
                AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus transaksi: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus transaksi.');
        }
    }

    public function deleteTransaction($data)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::find($data[0]);
            if ($transaction) {
                $transaction->delete();
                DB::commit();

                return AlertHelper::success('Berhasil', 'Transaksi berhasil dihapus.');
            } else {
                AlertHelper::error('Gagal', 'Transaksi tidak ditemukan.');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus transaksi: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus transaksi.');
        }
    }

    public function updated($property)
    {
        if (in_array($property, [
            'search',
            'status',
            'date',
            'type_transaction',
            'patient_company_role_transaction_id',
        ])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->type_transaction = '';
        $this->date = '';
        $this->patient_company_role_transaction_id = '';
        $this->resetPage();
    }

    public function confirmCloseCashier()
    {
        return AlertHelper::confirmSave('closeCashier', 'Apakah Anda yakin ingin menutup kasir ini? Pastikan semua transaksi telah selesai.');
    }

    public function closeCashier()
    {
        try {
            DB::beginTransaction();

            $cash = Cash::where('company_id', Auth::user()->company_id)
                ->where('user_id', Auth::user()->id)
                ->where('is_active', true)
                ->first();

            if ($cash) {
                $cash->end_date = Carbon::now();
                $cash->is_active = false;
                $cash->save();
            }

            DB::commit();

            session()->flash('saved', [
                'title' => 'Kasir Ditutup!',
                'text' => 'Anda berhasil menutup kasir.',
            ]);

            return redirect()->route('user.sale.pos');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menutup kasir: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            AlertHelper::error('Gagal', 'Terjadi kesalahan saat menutup kasir.');
        }
    }

    public function render()
    {
        // Ambil hanya kolom yang dibutuhkan
        $transactions = Transaction::query()
            ->select([
                'id',
                'code',
                'created_at',
                'status',
                'type',
                'patient_name',
                'patient_company_role_id',
                'location_name',
                'doctor_name',
                'grand_total_price',
            ])
            ->where('company_id', Auth::user()->company_id)
            ->whereIn('status', ['draft', 'process', 'take_medicine', 'completed', 'canceled'])

            // ✅ Gunakan pencarian efisien (case insensitive)
            ->when($this->search, function ($q) {
                $term = trim($this->search);
                $q->where('code', 'ilike', "%{$term}%");
            })

            // ✅ Filter kondisi ringan (gunakan index bila ada)
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->type_transaction, fn ($q) => $q->where('type', $this->type_transaction))

            // ✅ Hindari parse date berulang
            ->when($this->date, fn ($q) => $q->whereDate('created_at', $this->date))

            // ✅ Filter pasien hanya jika dipilih
            ->when(
                $this->patient_company_role_transaction_id,
                fn ($q) => $q->where('patient_company_role_id', $this->patient_company_role_transaction_id)
            )

            // ✅ Hitung rekam resep tanpa harus menarik N+1 query table transactionRecipes di blade
            ->withCount('transactionRecipes')

            // ✅ Urutan berdasarkan waktu terbaru
            ->latest('created_at');

        // ✅ Cache query ringan (opsional, 30 detik)
        // $transactions = Cache::remember('transactions_'.$this->page.'_'.$this->search, 30, fn() => $transactions->paginate($this->perPage));

        $patients = collect();
        if ($this->type_customer == 'member') {
            $patientsQuery = UserCompanyRole::companyRole('Pasien', Auth::user()->company_id)
                ->with('user:id,name,phone') // hanya ID, Nama, dan Phone
                ->select('id', 'user_id', 'medical_record_number');

            if ($this->searchModalPatient) {
                $search = $this->searchModalPatient;
                $patientsQuery->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($u) use ($search) {
                        $u->where('name', 'ilike', '%'.$search.'%')
                            ->orWhere('phone', 'ilike', '%'.$search.'%');
                    })
                        ->orWhere('medical_record_number', 'ilike', '%'.$search.'%');
                });
            }

            // Urutkan berdasarkan rekam medis / update terbaru
            $patients = $patientsQuery->latest()->paginate(5, ['*'], 'patientPage');
        }

        $genders = MasterPatientAdministrativeGender::select('code', 'display')
            ->whereIn('code', ['male', 'female'])
            ->get()
            ->toArray();

        $doctors = [];
        if ($this->type == 'resep' && $this->type_doctor == 'old') {
            $doctors = Doctor::where('company_id', Auth::user()->company_id)
                ->select('id', 'name', 'type', 'specialization')
                ->get()
                ->toArray();
        }

        return view('livewire.admin.sale.pos.admin-sale-pos-index', [
            'transactions' => $transactions->paginate($this->perPage),
            'patients' => $patients,
            'genders' => $genders,
            'doctors' => $doctors,
        ])
            ->extends('layout.pos.app')
            ->section('content');
    }
}
