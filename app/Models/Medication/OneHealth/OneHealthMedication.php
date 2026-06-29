<?php

namespace App\Models\Medication\OneHealth;

use App\Models\Master\CodeSystem\Medication\MasterMedicationStatus;
use App\Models\Medication\Medication;
use App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense;
use App\Models\MedicationRequest\OneHealth\OneHealthMedicationRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OneHealthMedication extends Model
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
            $modelCreate->createOHIdentifier();
        });
        static::saved(function ($model) {});
    }

    public function createOHIdentifier()
    {
        $this->OHMedicationIdentifier()->create([
            'one_health_organization_id' => $this->medication?->company?->OHOrganization?->id,
            'value' => $this->id,
        ]);
    }

    /**
     * Get the medication that owns the OneHealthMedication
     */
    public function medication(): BelongsTo
    {
        return $this->belongsTo(Medication::class, 'medication_id', 'id');
    }

    /**
     * Get the OHMedicationIdentifier associated with the OneHealthMedication
     */
    public function OHMedicationIdentifier(): HasOne
    {
        return $this->hasOne(OneHealthMedicationIdentifier::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get the OHMedocationCode associated with the OneHealthMedication
     */
    public function OHMedicationCode(): HasOne
    {
        return $this->hasOne(OneHealthMedicationCode::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get the status that owns the OneHealthMedication
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(MasterMedicationStatus::class, 'status', 'code');
    }

    /**
     * Get all of the OHMedicationFormCodings for the OneHealthMedication
     */
    public function OHMedicationForm(): HasOne
    {
        return $this->hasOne(OneHealthMedicationForm::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get all of the OHIngredients for the OneHealthMedication
     */
    public function OHIngredients(): HasMany
    {
        return $this->hasMany(OneHealthMedicationIngredient::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get the OHExtension associated with the OneHealthMedication
     */
    public function OHExtension(): HasOne
    {
        return $this->hasOne(OneHealthMedicationExtension::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get all of the OHMedicationReqs for the OneHealthMedication
     */
    public function OHMedicationReqs(): HasMany
    {
        return $this->hasMany(OneHealthMedicationRequest::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get all of the OHMedicationDispenses for the OneHealthMedication
     */
    public function OHMedicationDispenses(): HasMany
    {
        return $this->hasMany(OneHealthMedicationDispense::class, 'one_health_medication_id', 'id');
    }
}
