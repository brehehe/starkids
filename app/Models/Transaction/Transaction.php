<?php

namespace App\Models\Transaction;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Deposit\Deposit;
use App\Models\Insurance\Insurance;
use App\Models\Location\Location;
use App\Models\Patient\PatientReferralIncentive;
use App\Models\Poly\Poly;
use App\Models\TransactionInstallment;
use App\Models\User;
use App\Models\User\ControlDoctor;
use App\Models\User\UserCompanyRole;
// use App\Observers\Transaction\TransactionDetailObserver;
// use App\Observers\Transaction\TransactionRecipeObserver;
// use App\Observers\TransactionObserver;
use App\Models\User\UserIncentive;
use App\Models\User\UserPrice;
use App\Models\User\UserType;
use App\Models\User\UserTypeIncentive;
use App\Services\DoctorIncentiveService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Transaction extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'consent_actions' => 'array',
        'consent_signee' => 'array',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function patientCompanyRole()
    {
        return $this->belongsTo(UserCompanyRole::class, 'patient_company_role_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function transactionRecipes()
    {
        return $this->hasMany(TransactionRecipe::class);
    }

    public function transactionDetailPackages()
    {
        return $this->hasMany(TransactionDetailPackage::class);
    }

    public function transactionPayments()
    {
        return $this->hasMany(TransactionPayment::class);
    }

    public function transactionInstallments()
    {
        return $this->hasMany(TransactionInstallment::class);
    }

    public function transactionPrimary()
    {
        return $this->belongsTo(TransactionPrimary::class, 'id', 'transaction_id');
    }

    public function transactionDiagnosis()
    {
        return $this->hasOne(TransactionDiagnosis::class, 'transaction_id', 'id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function controlDoctor()
    {
        return $this->belongsTo(ControlDoctor::class, 'control_doctor_id');
    }

    public function poly()
    {
        return $this->belongsTo(Poly::class, 'poly_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function scopeSearch($query, $search)
    {
        if (! empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('code', 'ilike', "%{$search}%")
                    ->orWhere('code_consultation', 'ilike', "%{$search}%")
                    ->orWhereHas('patient', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%");
                    })->orWhereHas('doctor', function ($query) use ($search) {
                        $query->where('name', 'ilike', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    public function transactionNurses()
    {
        return $this->hasMany(TransactionNurse::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
            $modelCreate->company_id = $modelCreate->company_id ?? auth()->user()->company_id;
            $modelCreate->branch_id = Branch::where('company_id', auth()->user()->company_id)->first()->id;
            $modelCreate->date = $modelCreate->date ?? now();
            $modelCreate->created_by = auth()->user()->id;
            $modelCreate->date = $modelCreate->date ?? date('Y-m-d');
            $modelCreate->user_type_id = $modelCreate->user_type_id ? $modelCreate->user_type_id : ($modelCreate->patient ? $modelCreate->patient->user_type_id : UserType::where('name', 'Umum')->first()->id); // Default to 'member' if not set
        });

        static::saved(function ($modelUpdate) {
            // TransactionDetail::observe(TransactionDetailObserver::class);
            // TransactionRecipe::observe(TransactionRecipeObserver::class);
        });

        static::updating(function ($modelUpdate) {
            try {
                // Force commit any pending transactions before proceeding
                $initialTransactionLevel = \DB::transactionLevel();
                if ($initialTransactionLevel > 0) {
                    while (\DB::transactionLevel() > 0) {
                        \DB::commit();
                    }
                }

                // Debug: Log status dan ID yang tersedia
                \Log::info('Transaction Update Debug', [
                    'transaction_id' => $modelUpdate->id,
                    'status' => $modelUpdate->status,
                    'doctor_id' => $modelUpdate->doctor_id,
                    'pharmacy_id' => $modelUpdate->pharmacy_id,
                    'cashier_id' => $modelUpdate->cashier_id,
                    'company_id' => $modelUpdate->company_id,
                    'grand_total_price' => $modelUpdate->grand_total_price,
                ]);

                if ($modelUpdate->status === 'completed') {
                    \Log::info('Status is completed, processing incentives...');

                    if ($modelUpdate->doctor_id) {
                        \Log::info('Processing doctor incentive for doctor_id: '.$modelUpdate->doctor_id);

                        // (1) Insentif global berbasis UserPrice (existing)
                        $modelUpdate->updateDoctorIncentive($modelUpdate, $modelUpdate->doctor_id, $modelUpdate->company_id);

                        // (2) Insentif per-tindakan berbasis DoctorActionIncentive (new)
                        try {
                            (new DoctorIncentiveService)->calculateForTransaction($modelUpdate);
                        } catch (\Throwable $e) {
                            \Log::error('DoctorIncentiveService gagal', [
                                'transaction_id' => $modelUpdate->id,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    } else {
                        \Log::warning('doctor_id is NULL or empty');
                    }

                    if ($modelUpdate->doctor_referral_id) {
                        \Log::info('Processing doctor referral incentive for: '.$modelUpdate->doctor_referral_id);
                        try {
                            (new DoctorIncentiveService)->calculateReferralIncentive($modelUpdate);
                        } catch (\Throwable $e) {
                            \Log::error('DoctorIncentiveService calculateReferralIncentive gagal', [
                                'transaction_id' => $modelUpdate->id,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }

                    if ($modelUpdate->pharmacy_id) {
                        \Log::info('Processing pharmacy incentive for pharmacy_id: '.$modelUpdate->pharmacy_id);
                        $modelUpdate->updatePharmacyIncentive($modelUpdate, $modelUpdate->pharmacy_id, $modelUpdate->company_id);
                    } else {
                        \Log::warning('pharmacy_id is NULL or empty');
                    }

                    if ($modelUpdate->cashier_id) {
                        \Log::info('Processing cashier incentive for cashier_id: '.$modelUpdate->cashier_id);
                        $modelUpdate->updateCashierIncentive($modelUpdate, $modelUpdate->cashier_id, $modelUpdate->company_id);
                    } else {
                        \Log::warning('cashier_id is NULL or empty');
                    }

                    if ($modelUpdate->transactionNurses && $modelUpdate->transactionNurses->count() > 0) {
                        \Log::info('Processing nurse incentives, count: '.$modelUpdate->transactionNurses->count());
                        foreach ($modelUpdate->transactionNurses as $nurse) {
                            $modelUpdate->updateNurseIncentive($modelUpdate, $nurse->nurse_id, $modelUpdate->company_id);
                        }
                    } else {
                        \Log::warning('No nurses found for this transaction');
                    }

                    // Process product-based incentives for transaction details
                    \Log::info('Processing product-based incentives for transaction details...');
                    $modelUpdate->updateProductBasedIncentives($modelUpdate, $modelUpdate->company_id);

                    // (3) Patient Referral Incentive
                    $modelUpdate->updatePatientReferralIncentive($modelUpdate);
                } else {
                    \Log::info('Transaction status is not completed: '.$modelUpdate->status);
                }
            } catch (\Exception|\Throwable $th) {
                \DB::rollBack();
                $error = [
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                    'trace' => $th->getTraceAsString(),
                ];
                \Log::error('Ada kesalahan saat boot Transaction sync', $error);

                // Re-throw exception untuk debugging
                throw $th;
            }
        });
    }

    public function updateDoctorIncentive($modelUpdate, $doctorId, $companyId)
    {
        \Log::info('updateDoctorIncentive START', [
            'doctorId' => $doctorId,
            'companyId' => $companyId,
            'transaction_id' => $modelUpdate->id,
        ]);

        $userPrice = UserPrice::where('user_id', $doctorId)
            ->where('company_id', $companyId)
            ->first();

        \Log::info('updateDoctorIncentive userPrice query result', [
            'userPrice_found' => $userPrice ? 'YES' : 'NO',
            'userPrice_data' => $userPrice ? $userPrice->toArray() : null,
        ]);

        $grandTotalPrice = $modelUpdate->grand_total_price ?? 0;

        if ($userPrice) {
            $tipeInsentifDokter = $userPrice->type_incentive_doctor ?? 'rupiah';

            if ($tipeInsentifDokter === 'persen') {
                $persentase = min($userPrice->incentive_doctor, 100);
                $jumlahInsentif = ($grandTotalPrice * $persentase) / 100;
            } else {
                $jumlahInsentif = $userPrice->incentive_doctor;
            }

            \Log::info('updateDoctorIncentive calculation', [
                'type' => $tipeInsentifDokter,
                'incentive_value' => $userPrice->incentive_doctor,
                'grand_total' => $grandTotalPrice,
                'calculated_amount' => $jumlahInsentif,
            ]);

            try {
                $result = UserIncentive::updateOrCreate(
                    [
                        'user_id' => $doctorId,
                        'transaction_id' => $modelUpdate->id,
                        'status' => 'dokter',
                    ],
                    [
                        'amount' => $jumlahInsentif,
                        'description' => "Insentif Dokter Utama dari Transaksi #{$modelUpdate?->code}",
                        'month' => date('m'),
                        'year' => date('Y'),
                    ]
                );

                \Log::info('updateDoctorIncentive SUCCESS', [
                    'user_incentive_id' => $result->id,
                    'was_recently_created' => $result->wasRecentlyCreated,
                ]);
            } catch (\Exception $e) {
                \Log::error('updateDoctorIncentive FAILED', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        } else {
            \Log::warning('updateDoctorIncentive - No userPrice found', [
                'doctorId' => $doctorId,
                'companyId' => $companyId,
            ]);
        }
    }

    public function updatePharmacyIncentive($modelUpdate, $pharmacyId, $companyId)
    {
        \Log::info('updatePharmacyIncentive START', [
            'pharmacyId' => $pharmacyId,
            'companyId' => $companyId,
            'transaction_id' => $modelUpdate->id,
        ]);

        $userPrice = UserPrice::where('user_id', $pharmacyId)
            ->where('company_id', $companyId)
            ->first();

        \Log::info('updatePharmacyIncentive userPrice query result', [
            'userPrice_found' => $userPrice ? 'YES' : 'NO',
            'userPrice_data' => $userPrice ? $userPrice->toArray() : null,
        ]);

        $grandTotalPrice = $modelUpdate->grand_total_price ?? 0;

        if ($userPrice) {
            // Cek apakah field incentive_pharmacy ada dan tidak null
            if (is_null($userPrice->incentive_pharmacy) || $userPrice->incentive_pharmacy == 0) {
                \Log::warning('updatePharmacyIncentive - incentive_pharmacy is null or zero', [
                    'incentive_pharmacy' => $userPrice->incentive_pharmacy,
                    'userPrice_data' => $userPrice->toArray(),
                ]);

                return;
            }

            $tipeInsentifApotek = $userPrice->type_incentive_pharmacy ?? 'rupiah';

            if ($tipeInsentifApotek === 'persen') {
                $persentase = min($userPrice->incentive_pharmacy, 100);
                $jumlahInsentif = ($grandTotalPrice * $persentase) / 100;
            } else {
                $jumlahInsentif = $userPrice->incentive_pharmacy;
            }

            \Log::info('updatePharmacyIncentive calculation', [
                'type' => $tipeInsentifApotek,
                'incentive_value' => $userPrice->incentive_pharmacy,
                'grand_total' => $grandTotalPrice,
                'calculated_amount' => $jumlahInsentif,
            ]);

            try {
                $result = UserIncentive::updateOrCreate(
                    [
                        'user_id' => $pharmacyId,
                        'transaction_id' => $modelUpdate->id,
                        'status' => 'apoteker',
                    ],
                    [
                        'amount' => $jumlahInsentif,
                        'description' => "Insentif Apoteker dari Transaksi #{$modelUpdate?->code}",
                        'month' => date('m'),
                        'year' => date('Y'),
                    ]
                );

                \Log::info('updatePharmacyIncentive SUCCESS', [
                    'user_incentive_id' => $result->id,
                    'was_recently_created' => $result->wasRecentlyCreated,
                ]);
            } catch (\Exception $e) {
                \Log::error('updatePharmacyIncentive FAILED', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        } else {
            \Log::warning('updatePharmacyIncentive - No userPrice found', [
                'pharmacyId' => $pharmacyId,
                'companyId' => $companyId,
            ]);
        }

        // Ganti Log::check dengan Log::info
        \Log::info('updatePharmacyIncentive DEBUG INFO', [
            'modelUpdate_id' => $modelUpdate->id,
            'modelUpdate_status' => $modelUpdate->status,
            'pharmacyId' => $pharmacyId,
            'companyId' => $companyId,
            'userPrice' => $userPrice ? $userPrice->toArray() : null,
            'grandTotalPrice' => $grandTotalPrice,
        ]);
    }

    public function updateCashierIncentive($modelUpdate, $cashierId, $companyId)
    {
        \Log::info('updateCashierIncentive START', [
            'cashierId' => $cashierId,
            'companyId' => $companyId,
            'transaction_id' => $modelUpdate->id,
        ]);

        $userPrice = UserPrice::where('user_id', $cashierId)
            ->where('company_id', $companyId)
            ->first();

        \Log::info('updateCashierIncentive userPrice query result', [
            'userPrice_found' => $userPrice ? 'YES' : 'NO',
            'userPrice_data' => $userPrice ? $userPrice->toArray() : null,
        ]);

        $grandTotalPrice = $modelUpdate->grand_total_price ?? 0;

        if ($userPrice) {
            // Cek apakah field incentive_cashier ada dan tidak null
            if (is_null($userPrice->incentive_cashier) || $userPrice->incentive_cashier == 0) {
                \Log::warning('updateCashierIncentive - incentive_cashier is null or zero', [
                    'incentive_cashier' => $userPrice->incentive_cashier,
                    'userPrice_data' => $userPrice->toArray(),
                ]);

                return;
            }

            $tipeInsentifKasir = $userPrice->type_incentive_cashier ?? 'rupiah';

            if ($tipeInsentifKasir === 'persen') {
                $persentase = min($userPrice->incentive_cashier, 100);
                $jumlahInsentif = ($grandTotalPrice * $persentase) / 100;
            } else {
                $jumlahInsentif = $userPrice->incentive_cashier;
            }

            \Log::info('updateCashierIncentive calculation', [
                'type' => $tipeInsentifKasir,
                'incentive_value' => $userPrice->incentive_cashier,
                'grand_total' => $grandTotalPrice,
                'calculated_amount' => $jumlahInsentif,
            ]);

            try {
                $result = UserIncentive::updateOrCreate(
                    [
                        'user_id' => $cashierId,
                        'transaction_id' => $modelUpdate->id,
                        'status' => 'kasir',
                    ],
                    [
                        'amount' => $jumlahInsentif,
                        'description' => "Insentif Kasir dari Transaksi #{$modelUpdate?->code}",
                        'month' => date('m'),
                        'year' => date('Y'),
                    ]
                );

                \Log::info('updateCashierIncentive SUCCESS', [
                    'user_incentive_id' => $result->id,
                    'was_recently_created' => $result->wasRecentlyCreated,
                ]);
            } catch (\Exception $e) {
                \Log::error('updateCashierIncentive FAILED', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        } else {
            \Log::warning('updateCashierIncentive - No userPrice found', [
                'cashierId' => $cashierId,
                'companyId' => $companyId,
            ]);
        }

        // Tambahkan debug info untuk cashier juga
        \Log::info('updateCashierIncentive DEBUG INFO', [
            'modelUpdate_id' => $modelUpdate->id,
            'modelUpdate_status' => $modelUpdate->status,
            'cashierId' => $cashierId,
            'companyId' => $companyId,
            'userPrice' => $userPrice ? $userPrice->toArray() : null,
            'grandTotalPrice' => $grandTotalPrice,
        ]);
    }

    public function updateNurseIncentive($modelUpdate, $nurseId, $companyId)
    {
        \Log::info('updateNurseIncentive START', [
            'nurseId' => $nurseId,
            'companyId' => $companyId,
            'transaction_id' => $modelUpdate->id,
        ]);

        $userPrice = UserPrice::where('user_id', $nurseId)
            ->where('company_id', $companyId)
            ->first();

        \Log::info('updateNurseIncentive userPrice query result', [
            'userPrice_found' => $userPrice ? 'YES' : 'NO',
            'userPrice_data' => $userPrice ? $userPrice->toArray() : null,
        ]);

        $grandTotalPrice = $modelUpdate->grand_total_price ?? 0;

        if ($userPrice) {
            $tipeInsentifPerawat = $userPrice->type_incentive_nurse ?? 'rupiah';

            if ($tipeInsentifPerawat === 'persen') {
                $persentase = min($userPrice->incentive_nurse, 100);
                $jumlahInsentif = ($grandTotalPrice * $persentase) / 100;
            } else {
                $jumlahInsentif = $userPrice->incentive_nurse;
            }

            \Log::info('updateNurseIncentive calculation', [
                'type' => $tipeInsentifPerawat,
                'incentive_value' => $userPrice->incentive_nurse,
                'grand_total' => $grandTotalPrice,
                'calculated_amount' => $jumlahInsentif,
            ]);

            try {
                $result = UserIncentive::updateOrCreate(
                    [
                        'user_id' => $nurseId,
                        'transaction_id' => $modelUpdate->id,
                        'status' => 'perawat',
                    ],
                    [
                        'amount' => $jumlahInsentif,
                        'description' => "Insentif Perawat dari Transaksi #{$modelUpdate?->code}",
                        'month' => date('m'),
                        'year' => date('Y'),
                    ]
                );

                \Log::info('updateNurseIncentive SUCCESS', [
                    'user_incentive_id' => $result->id,
                    'was_recently_created' => $result->wasRecentlyCreated,
                ]);
            } catch (\Exception $e) {
                \Log::error('updateNurseIncentive FAILED', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        } else {
            \Log::warning('updateNurseIncentive - No userPrice found', [
                'nurseId' => $nurseId,
                'companyId' => $companyId,
            ]);
        }
    }

    public function transactionIcd10()
    {
        return $this->hasMany(TransactionIcd10::class);
    }

    public function updateProductBasedIncentives($modelUpdate, $companyId)
    {
        \Log::info('updateProductBasedIncentives START', [
            'transaction_id' => $modelUpdate->id,
            'companyId' => $companyId,
        ]);

        // Load transaction details with product relationship
        $transactionDetails = $modelUpdate->transactionDetails()
            ->whereNotNull('product_id')
            ->with('product')
            ->get();

        \Log::info('updateProductBasedIncentives - Transaction details count', [
            'count' => $transactionDetails->count(),
        ]);

        foreach ($transactionDetails as $detail) {
            if (! $detail->product) {
                \Log::warning('updateProductBasedIncentives - Product not found for detail', [
                    'detail_id' => $detail->id,
                ]);

                continue;
            }

            $product = $detail->product;
            $subTotalPrice = $detail->sub_total_price ?? 0;
            $quantity = $detail->quantity ?? 1;

            \Log::info('updateProductBasedIncentives - Processing detail', [
                'detail_id' => $detail->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'sub_total_price' => $subTotalPrice,
                'quantity' => $quantity,
                'nurse_id' => $detail->nurse_id,
                'doctor_id' => $detail->doctor_id,
            ]);

            // Calculate Nurse Incentive
            if ($detail->nurse_id && $product->incentive_nurse > 0) {
                $nurseIncentive = 0;

                if ($product->type_incentive_nurse === 'percentage') {
                    $percentage = min($product->incentive_nurse, 100);
                    $nurseIncentive = ($subTotalPrice * $percentage) / 100;
                } else {
                    $nurseIncentive = $product->incentive_nurse * $quantity;
                }

                \Log::info('updateProductBasedIncentives - Nurse incentive calculated', [
                    'detail_id' => $detail->id,
                    'nurse_id' => $detail->nurse_id,
                    'type' => $product->type_incentive_nurse,
                    'incentive_value' => $product->incentive_nurse,
                    'calculated_amount' => $nurseIncentive,
                ]);

                // Update transaction detail
                $detail->incentive_nurse = $nurseIncentive;

                // Create/Update user incentive record
                try {
                    $result = UserIncentive::updateOrCreate(
                        [
                            'user_id' => $detail->nurse_id,
                            'transaction_id' => $modelUpdate->id,
                            'transaction_detail_id' => $detail->id,
                            'status' => 'perawat_produk',
                        ],
                        [
                            'amount' => $nurseIncentive,
                            'description' => "Insentif Perawat untuk Produk {$product?->name} dari Transaksi #{$modelUpdate?->code}",
                            'month' => date('m'),
                            'year' => date('Y'),
                        ]
                    );

                    \Log::info('updateProductBasedIncentives - Nurse incentive saved', [
                        'user_incentive_id' => $result->id,
                        'was_recently_created' => $result->wasRecentlyCreated,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('updateProductBasedIncentives - Nurse incentive save FAILED', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }

            // Calculate Doctor Incentive
            if ($detail->doctor_id && $product->incentive_doctor > 0) {
                $doctorIncentive = 0;

                if ($product->type_incentive_doctor === 'percentage') {
                    $percentage = min($product->incentive_doctor, 100);
                    $doctorIncentive = ($subTotalPrice * $percentage) / 100;
                } else {
                    $doctorIncentive = $product->incentive_doctor * $quantity;
                }

                \Log::info('updateProductBasedIncentives - Doctor incentive calculated', [
                    'detail_id' => $detail->id,
                    'doctor_id' => $detail->doctor_id,
                    'type' => $product->type_incentive_doctor,
                    'incentive_value' => $product->incentive_doctor,
                    'calculated_amount' => $doctorIncentive,
                ]);

                // Update transaction detail
                $detail->incentive_doctor = $doctorIncentive;

                // Create/Update user incentive record
                try {
                    $result = UserIncentive::updateOrCreate(
                        [
                            'user_id' => $detail->doctor_id,
                            'transaction_id' => $modelUpdate->id,
                            'transaction_detail_id' => $detail->id,
                            'status' => 'dokter_produk',
                        ],
                        [
                            'amount' => $doctorIncentive,
                            'description' => "Insentif Dokter untuk Produk {$product?->name} dari Transaksi #{$modelUpdate?->code}",
                            'month' => date('m'),
                            'year' => date('Y'),
                        ]
                    );

                    \Log::info('updateProductBasedIncentives - Doctor incentive saved', [
                        'user_incentive_id' => $result->id,
                        'was_recently_created' => $result->wasRecentlyCreated,
                    ]);
                } catch (\Exception $e) {
                    \Log::error('updateProductBasedIncentives - Doctor incentive save FAILED', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]);
                }
            }

            // Save the transaction detail with updated incentives
            try {
                $detail->save();
                \Log::info('updateProductBasedIncentives - Transaction detail updated', [
                    'detail_id' => $detail->id,
                    'incentive_nurse' => $detail->incentive_nurse,
                    'incentive_doctor' => $detail->incentive_doctor,
                ]);
            } catch (\Exception $e) {
                \Log::error('updateProductBasedIncentives - Transaction detail save FAILED', [
                    'detail_id' => $detail->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        \Log::info('updateProductBasedIncentives END');
    }

    public function transactionPhysicalExamination()
    {
        return $this->hasOne(TransactionPhysicalExamination::class);
    }

    public function transactionCondition()
    {
        return $this->hasOne(TransactionCondition::class);
    }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'deposit_id');
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }

    /**
     * Update patient referral incentive when a transaction is completed.
     * Awarded only for the first completed transaction of the referred patient.
     */
    public function updatePatientReferralIncentive($modelUpdate)
    {
        \Log::info('updatePatientReferralIncentive START', [
            'transaction_id' => $modelUpdate->id,
            'patient_id' => $modelUpdate->patient_id,
        ]);

        $patient = $modelUpdate->patient;
        if (! $patient || ! $patient->user_id) {
            \Log::info('No referrer found for patient', ['patient_id' => $modelUpdate->patient_id]);

            return;
        }

        $referrerId = $patient->user_id;
        $referralUserTypeId = $patient->user_type_id;

        // Check if a referral incentive has already been awarded for this patient
        $existingIncentive = PatientReferralIncentive::where('referred_id', $modelUpdate->patient_id)->exists();
        if ($existingIncentive) {
            \Log::info('Referral incentive already awarded for this patient', ['patient_id' => $modelUpdate->patient_id]);

            return;
        }

        // Check if this is the patient's first completed transaction
        $completedTransactionsCount = Transaction::where('patient_id', $modelUpdate->patient_id)
            ->where('status', 'completed')
            ->where('id', '!=', $modelUpdate->id)
            ->count();

        if ($completedTransactionsCount > 0) {
            \Log::info('Not the first completed transaction for patient', [
                'patient_id' => $modelUpdate->patient_id,
                'count' => $completedTransactionsCount,
            ]);

            return;
        }

        $grandTotalPrice = $modelUpdate->grand_total_price ?? 0;

        // Find incentive rule based on the patient's referral user type
        $userTypeIncentive = UserTypeIncentive::findIncentiveForUserType(
            $referralUserTypeId,
            $grandTotalPrice,
            $modelUpdate->company_id
        );

        if (! $userTypeIncentive) {
            \Log::info('No matching UserTypeIncentive found', [
                'user_type_id' => $referralUserTypeId,
                'amount' => $grandTotalPrice,
            ]);

            return;
        }

        $incentiveAmount = $userTypeIncentive->calculateIncentive($grandTotalPrice);

        try {
            $result = PatientReferralIncentive::updateOrCreate(
                [
                    'referred_id' => $modelUpdate->patient_id,
                    'transaction_id' => $modelUpdate->id,
                ],
                [
                    'referrer_id' => $referrerId,
                    'amount' => $incentiveAmount,
                    'incentive_type' => $userTypeIncentive->incentive_type,
                    'status' => 'pending',
                    'month' => date('m'),
                    'year' => date('Y'),
                    'company_id' => $modelUpdate->company_id,
                ]
            );

            \Log::info('updatePatientReferralIncentive SUCCESS', [
                'incentive_id' => $result->id,
            ]);
        } catch (\Exception $e) {
            \Log::error('updatePatientReferralIncentive FAILED', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
