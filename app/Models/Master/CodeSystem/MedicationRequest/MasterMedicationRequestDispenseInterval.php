<?php

namespace App\Models\Master\CodeSystem\MedicationRequest;

use App\Models\MedicationRequest\MedicationRequestDispenseRequest;
use App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDispenseRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMedicationRequestDispenseInterval extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
        });
    }

    /**
     * Get all of the  for the MasterMedicationRequestDispanseInterval
     */
    public function medicationReqDispenseRequest(): HasMany
    {
        return $this->hasMany(MedicationRequestDispenseRequest::class, 'dispense_interval_code', 'code');
    }

    /**
     * Get all of the medi for the MasterMedicationRequestDispenseInterval
     */
    public function OHedicationReqDispanseRequest(): HasMany
    {
        return $this->hasMany(OneHealthMedicationRequestDispenseRequest::class, 'dispense_interval_code', 'code');
    }
}
