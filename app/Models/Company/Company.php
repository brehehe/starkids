<?php

namespace App\Models\Company;

use App\Models\Company\OneHealth\OneHealthOrganization;
use App\Models\Condition\Condition;
use App\Models\Medication\Medication;
use App\Models\MedicationDispense\MedicationDispense;
use App\Models\MedicationRequest\MedicationRequest;
use App\Models\MedicationRequest\MedicationRequestDispenseRequest;
use App\Models\MedicineType\MedicineType;
use App\Models\Patient\PatientCompany;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Services\System\Organizaion\OneHealthOrganizationService;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Company extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        // 'one_health_access_token' => 'encrypted',
    ];

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
        });

        static::saved(function ($model) {
            try {
                // Skip if only one_health_access_token was changed to prevent infinite loop
                if ($model->wasChanged(['one_health_access_token']) && count($model->getChanges()) === 2) {
                    return;
                }

                // Force commit any pending transactions before proceeding
                $initialTransactionLevel = DB::transactionLevel();
                if ($initialTransactionLevel > 0) {

                    while (DB::transactionLevel() > 0) {
                        DB::commit();
                    }
                }

                // app(OneHealthOrganizationService::class)->updateOrCreate($model);
            } catch (Exception|Throwable $th) {
                DB::rollBack();
                $error = [
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                ];

                Log::error('Ada kesalahan saat boot Company sync', $error);
            }
        });
    }

    /**
     * Get the user associated with the Company
     */
    public function oneHealthy(): HasOne
    {
        return $this->hasOne(OneHealthy::class, 'company_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'company_id', 'id');
    }

    /**
     * Get the user associated with the Company
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'company_id', 'id');
    }

    /**
     * Get the companyDetail associated with the Company
     */
    public function companyDetail(): HasOne
    {
        return $this->hasOne(CompanyDetail::class, 'company_id', 'id');
    }

    public function medicineTypes()
    {
        return $this->hasMany(MedicineType::class, 'company_id', 'id');
    }

    /**
     * Get the OHOrganization associated with the Company
     */
    public function OHOrganization(): HasOne
    {
        return $this->hasOne(OneHealthOrganization::class, 'company_id', 'id');
    }

    /**
     * Get all of the patientCompany for the Company
     */
    public function patientCompany(): HasMany
    {
        return $this->hasMany(PatientCompany::class, 'company_id', 'id');
    }

    /**
     * Get all of the conditions for the Company
     */
    public function conditions(): HasMany
    {
        return $this->hasMany(Condition::class, 'company_id', 'id');
    }

    /**
     * Get all of the medications for the Company
     */
    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class, 'company_id', 'id');
    }

    /**
     * Get all of the medicationRequests for the Company
     */
    public function medicationReqs(): HasMany
    {
        return $this->hasMany(MedicationRequest::class, 'company_id', 'id');
    }

    public function requestMedicationReqs()
    {
        return $this->morphMany(MedicationRequest::class, 'requestable');
    }

    public function performerMedicationDispenses()
    {
        return $this->morphMany(MedicationDispense::class, 'performerable');
    }

    /**
     * Get all of the medicationReqDispanse for the Company
     */
    public function medicationReqDispanse(): HasMany
    {
        return $this->hasMany(MedicationRequestDispenseRequest::class, 'company_id', 'id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%'.$search.'%')
                ->orWhere('code', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%')
                ->orWhere('website', 'like', '%'.$search.'%')
                ->orWhere('pic_name', 'like', '%'.$search.'%')
                ->orWhere('pic_email', 'like', '%'.$search.'%')
                ->orWhere('pic_phone', 'like', '%'.$search.'%')
                ->orWhere('pic_position', 'like', '%'.$search.'%')
                ->orWhereHas('companyDetail', function ($q) use ($search) {
                    $q->where('address', 'like', '%'.$search.'%')
                        ->orWhere('city', 'like', '%'.$search.'%')
                        ->orWhere('province', 'like', '%'.$search.'%')
                        ->orWhere('postal_code', 'like', '%'.$search.'%');
                });
        });
    }

    public function getNameMainAttribute(): string
    {
        $is_main = $this->is_main ? ' (Utama)' : ' (Cabang)';

        return $this->name.$is_main;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'company_id', 'id');
    }
}
