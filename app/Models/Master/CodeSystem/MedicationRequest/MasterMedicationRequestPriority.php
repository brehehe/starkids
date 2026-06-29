<?php

namespace App\Models\Master\CodeSystem\MedicationRequest;

use App\Models\MedicationRequest\MedicationRequest;
use App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMedicationRequestPriority extends Model
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
     * Get all of the medicationReq for the MasterMedicationRequestPriority
     */
    public function medicationReq(): HasMany
    {
        return $this->hasMany(MedicationRequest::class, 'priority', 'code');
    }

    /**
     * Get all of the OHMedicationReq for the MasterMedicationRequestPriority
     */
    public function OHMedicationReq(): HasMany
    {
        return $this->hasMany(OneHealthMedicationRequest::class, 'priority', 'code');
    }
}
