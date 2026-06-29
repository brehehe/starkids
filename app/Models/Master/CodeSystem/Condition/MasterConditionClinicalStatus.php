<?php

namespace App\Models\Master\CodeSystem\Condition;

use App\Models\Condition\OneHealth\OneHealthConditionClinicalStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterConditionClinicalStatus extends Model
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
     * Get all of the OHMedicationClinicalStatus for the MasterConditionClinicalStatus
     */
    public function OHMedicationClinicalStatus(): HasMany
    {
        return $this->hasMany(OneHealthConditionClinicalStatus::class, 'coding_code', 'code');
    }
}
