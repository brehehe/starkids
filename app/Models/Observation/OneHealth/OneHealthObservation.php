<?php

namespace App\Models\Observation\OneHealth;

use App\Models\Company\OneHealth\OneHealthOrganization;
use App\Models\Encounter\OneHealth\OneHealthEncounter;
use App\Models\Observation\Observation;
use App\Models\Patient\OneHealth\OneHealthPatient;
use App\Models\Practitiont\OneHealth\OneHealthPractitioner;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OneHealthObservation extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'effective_date_time' => 'date',
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

    /**
     * Get the observation that owns the OneHealthObservation
     */
    public function observation(): BelongsTo
    {
        return $this->belongsTo(Observation::class, 'observation_id', 'id');
    }

    /**
     * Get the OHOrganization that owns the OneHealthObservation
     */
    public function OHOrganization(): BelongsTo
    {
        return $this->belongsTo(OneHealthOrganization::class, 'one_health_organization_id', 'id');
    }

    /**
     * Get the OHPractitioner that owns the OneHealthObservation
     */
    public function OHPractitioner(): BelongsTo
    {
        return $this->belongsTo(OneHealthPractitioner::class, 'one_health_practitioner_id', 'id');
    }

    /**
     * Get the OHPatient that owns the OneHealthObservation
     */
    public function OHPatient(): BelongsTo
    {
        return $this->belongsTo(OneHealthPatient::class, 'one_health_patient_id', 'id');
    }

    /**
     * Get the OHEncounter that owns the OneHealthObservation
     */
    public function OHEncounter(): BelongsTo
    {
        return $this->belongsTo(OneHealthEncounter::class, 'one_health_encounter_id', 'id');
    }

    /**
     * Get the OHObservation associated with the OneHealthObservation
     */
    public function OHObservationCategory(): HasOne
    {
        return $this->hasOne(OneHealthObservationCategory::class, 'one_health_observation_id', 'id');
    }

    /**
     * Get the OHObservation associated with the OneHealthObservation
     */
    public function OHObservationCode(): HasOne
    {
        return $this->hasOne(OneHealthObservationCode::class, 'one_health_observation_id', 'id');
    }

    /**
     * Get the OHObservationValueQuantity associated with the OneHealthObservation
     */
    public function OHObservationValueQuantity(): HasOne
    {
        return $this->hasOne(OneHealthObservationValueQuantity::class, 'one_health_observation_id', 'id');
    }
}
