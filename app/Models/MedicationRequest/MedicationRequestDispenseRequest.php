<?php

namespace App\Models\MedicationRequest;

use App\Models\Company\Company;
use App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDispenseRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicationRequestDispenseRequest extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'validity_start' => 'date',
        'validity_end' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
        });
    }

    /**
     * Get the medicationReq that owns the MedicationRequestDispanseRequest
     */
    public function medicationReq(): BelongsTo
    {
        return $this->belongsTo(MedicationRequest::class, 'medication_request_id', 'id');
    }

    /**
     * Get the company that owns the MedicationRequestDispanseRequest
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * Get the OHMedicationReqDispanseRequest associated with the MedicationRequestDispenseRequest
     */
    public function OHMedicationReqDispanseRequest(): HasOne
    {
        return $this->hasOne(OneHealthMedicationRequestDispenseRequest::class, 'medication_request_dispense_request_id', 'id');
    }
}
