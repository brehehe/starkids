<?php

namespace App\Models\Master\CodeSystem\MedicationRequest;

use App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequestDispenseRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterMedicationRequestDispenseExpect extends Model
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
     * Get all of the OHMedicationRequestDispenceRequest for the MasterMedicationRequestDispenseExpect
     */
    public function OHMedicationRequestDispenceRequest(): HasMany
    {
        return $this->hasMany(OneHealthMedicationRequestDispenseRequest::class, 'expect_code', 'code');
    }
}
