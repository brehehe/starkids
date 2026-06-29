<?php

namespace App\Models\Master\CodeSystem\MedicationRequest;

use App\Models\MedicationRequest\MedicationRequestDosageInstruction;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMedicationRequestOrderableDrugForm extends Model
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
     * Get all of the medicationReq for the MasterMedicationRequestOrderableDrugForm
     */
    public function medicationReqDosageInstructions(): HasMany
    {
        return $this->hasMany(MedicationRequestDosageInstruction::class, 'dose_rate_quantity_code', 'code');
    }

    public function getCodeDisplayAttribute()
    {
        return $this->code.' - '.$this->display;
    }
}
