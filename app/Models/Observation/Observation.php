<?php

namespace App\Models\Observation;

use App\Models\Company\Company;
use App\Models\Encounter\Encounter;
use App\Models\Observation\OneHealth\OneHealthObservation;
use App\Models\Patient\Patient;
use App\Models\Practitiont\Practitioner;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observation extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'effectived_date_time' => 'date',
        'issued' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * Get the practitioner that owns the Observation
     */
    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(Practitioner::class, 'practitioner_id', 'id');
    }

    /**
     * Get the petient that owns the Observation
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    /**
     * Get the encounter that owns the Observation
     */
    public function encounter(): BelongsTo
    {
        return $this->belongsTo(Encounter::class, 'encounter_id', 'id');
    }

    /**
     * Get the OHObservation associated with the Observation
     */
    public function OHObservation(): HasOne
    {
        return $this->hasOne(OneHealthObservation::class, 'observation_id', 'id');
    }
}
