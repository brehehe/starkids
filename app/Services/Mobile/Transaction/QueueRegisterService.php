<?php

namespace App\Services\Mobile\Transaction;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Encounter\Encounter;
use App\Models\Location\Location;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
use App\Models\Product\Product;
use App\Models\Spatie\Role;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\User;
use App\Models\User\ControlDoctor;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserPrice;
use App\service\apiservice;

class QueueRegisterService
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

    public function createQueue($polyclinicId, $doctorId, $userId, $date, $doctorScheduleId)
    {
        $polyclinic = Location::find($polyclinicId);

        $doctor = User::find($doctorId);

        $patient = User::find($userId);

        $branch = Branch::where('company_id', $this->company?->id)->first();

        $doctorSchedule = ControlDoctor::find($doctorScheduleId);

        $patientRole = Role::where('name', 'Pasien')->first();

        $patientCompanyRole = UserCompanyRole::where('user_id', $patient->id)
            ->where('company_id', $this->company?->id)
            ->where('role_id', $patientRole->uuid)
            ->first();

        $lastTransaction = Transaction::withTrashed() // penting, cek termasuk yang soft delete
            ->whereDate('created_at', now())
            ->orderByDesc('code')
            ->lockForUpdate()
            ->first();

        // generate number
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
        $locationCode = strtoupper(implode('', array_map(fn ($word) => $word[0], explode(' ', $polyclinic->name))));
        $todayCount = Transaction::where('location_id', $polyclinicId)
            ->where('doctor_id', $doctorId)
            ->where('control_doctor_id', $doctorScheduleId)
            ->whereDate('date', $date)
            ->count() + 1;

        $codeConsultation = $locationCode.str_pad($todayCount, 4, '0', STR_PAD_LEFT);

        // Create transaction
        $transactionData = [
            'code' => $code.rand(100, 999),
            'code_consultation' => $codeConsultation,
            'doctor_id' => $doctor?->id,
            'doctor_name' => $doctor->name,
            'location_id' => $polyclinic?->id,
            'location_name' => $polyclinic->name,
            'control_doctor_id' => $doctorSchedule?->id,
            'patient_id' => $userId,
            'insurance_id' => null,
            'insurance_number' => null,
            'patient_name' => $patient?->name,
            'patient_company_role_id' => $patientCompanyRole?->id,
            'user_type_id' => $patient?->user_type_id,
            'deposit_id' => null,                           // Add deposit_id
            'date' => $date,
            'days' => $this->days ?? date('l', strtotime($date)),
            'branch_id' => $branch?->id,
            'type_customer' => true ? 'member' : 'new',
            'type_doctor' => true ? 'old' : 'new',
            'type' => 'konsultasi',
            'status' => 'waiting_consultation',
            'consultation' => 'yes',
            'created_at' => now(),
            'updated_at' => now(),
            'user_control_schedule_id' => $doctorSchedule?->id ?? null,
            'is_insurance' => false,
        ];

        $transaction = Transaction::create($transactionData);

        // Create consultation fee if no deposit is used
        $product = Product::where('name', 'Biaya Konsultasi')
            ->where('company_id', $this->company?->id)
            ->first();

        $userPrice = UserPrice::where('user_id', $doctor?->id)
            ->first();

        TransactionDetail::create([
            'transaction_id' => $transaction?->id,
            'user_id' => $doctor?->id,
            'product_id' => $product?->id ?? null,
            'quantity' => 1,
            'name' => 'Biaya Konsultasi',
            'price' => $userPrice?->price_doctor ?? 0,
            'price_hpp' => 0,
            'sub_total_price' => $userPrice?->price_doctor ?? 0,
            'sub_total_price_hpp' => 0,
            'type_transaction' => 'other',
        ]);

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

        // app(apiservice::class)->createTransaction($data);

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

        // app(apiservice::class)->createTransaction($data);

        return $transaction;
    }

    public function getQueueRegisterFamilyMember($userIds = [], $data = [])
    {
        return Transaction::whereIn('patient_id', $userIds)
            ->whereIn('status', $data['status'] ?? [])
            ->where('company_id', $this->company?->id)
            ->orderBy('date', 'ASC')
            ->get();
    }
}
