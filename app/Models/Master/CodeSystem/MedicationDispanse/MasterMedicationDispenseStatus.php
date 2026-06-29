<?php

namespace App\Models\Master\CodeSystem\MedicationDispanse;

use App\Models\MedicationDispense\MedicationDispense;
use App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMedicationDispenseStatus extends Model
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
     * Get all of the medicationDispenses for the MasterMedicationDispenseStatus
     */
    public function medicationDispenses(): HasMany
    {
        return $this->hasMany(MedicationDispense::class, 'status', 'code');
    }

    /**
     * Get all of the medicationDispenses for the MasterMedicationDispenseStatus
     */
    public function OHMedicationDispenses(): HasMany
    {
        return $this->hasMany(OneHealthMedicationDispense::class, 'status', 'code');
    }
}
