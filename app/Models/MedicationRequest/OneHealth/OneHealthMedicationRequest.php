<?php

namespace App\Models\MedicationRequest\OneHealth;

use App\Models\Company\OneHealth\OneHealthOrganization;
use App\Models\Encounter\OneHealth\OneHealthEncounter;
use App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestIntent;
use App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestPriority;
use App\Models\Master\CodeSystem\MedicationRequest\MasterMedicationRequestStatus;
use App\Models\Medication\OneHealth\OneHealthMedication;
use App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense;
use App\Models\MedicationRequest\MedicationRequest;
use App\Models\Patient\OneHealth\OneHealthPatient;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OneHealthMedicationRequest extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'author_on' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
            $modelCreate->createOHIdentifier();
            // $modelCreate->medication_display = $modelCreate?->medicationReq?->medication?->code_coding_display;
        });

        static::saved(function ($model) {
            // // Force commit any pending transactions before proceeding
            // $initialTransactionLevel = DB::transactionLevel();
            // if ($initialTransactionLevel > 0) {

            //     while (DB::transactionLevel() > 0) {
            //         DB::commit();
            //     }
            // }

            // $model->updateQuietly([
            //     // 'medication_display' => $model?->medicationReq?->medication?->code_coding_display
            // ]);
        });
    }

    public function createOHIdentifier()
    {
        $this->OHMedicationReqIdentifiers()->create([
            'one_health_organization_id' => $this->medicationReq?->company?->OHOrganization?->id,
            'value' => $this->id,
        ]);
    }

    /**
     * Get the medicationRequest that owns the OneHealthMedicationRequest
     */
    public function medicationReq(): BelongsTo
    {
        return $this->belongsTo(MedicationRequest::class, 'medication_request_id', 'id');
    }

    /**
     * Get all of the OHMedicationReqIdentifiers for the OneHealthMedicationRequest
     */
    public function OHMedicationReqIdentifiers(): HasMany
    {
        return $this->hasMany(OneHealthMedicationRequestIdentifier::class, 'one_health_medication_request_id', 'id');
    }

    /**
     * Get the OHMedicationReqCategory associated with the OneHealthMedicationRequest
     */
    public function OHMedicationReqCategory(): HasOne
    {
        return $this->hasOne(OneHealthMedicationRequestCategory::class, 'one_health_medication_request_id', 'id');
    }

    /**
     * Get the status that owns the OneHealthMedicationRequest
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(MasterMedicationRequestStatus::class, 'status', 'code');
    }

    /**
     * Get the intent that owns the OneHealthMedicationRequest
     */
    public function intent(): BelongsTo
    {
        return $this->belongsTo(MasterMedicationRequestIntent::class, 'intent', 'code');
    }

    /**
     * Get the priority that owns the OneHealthMedicationRequest
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(MasterMedicationRequestPriority::class, 'priority', 'code');
    }

    /**
     * Get the OHOrganization that owns the OneHealthMedicationRequest
     */
    public function OHOrganization(): BelongsTo
    {
        return $this->belongsTo(OneHealthOrganization::class, 'one_health_organization_id', 'id');
    }

    /**
     * Get the OHPatient that owns the OneHealthMedicationRequest
     */
    public function OHPatient(): BelongsTo
    {
        return $this->belongsTo(OneHealthPatient::class, 'one_health_patient_id', 'id');
    }

    /**
     * Get the OHMedication that owns the OneHealthMedicationRequest
     */
    public function OHMedication(): BelongsTo
    {
        return $this->belongsTo(OneHealthMedication::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get the OHEncounter that owns the OneHealthMedicationRequest
     */
    public function OHEncounter(): BelongsTo
    {
        return $this->belongsTo(OneHealthEncounter::class, 'one_health_encounter_id', 'id');
    }

    /**
     * Get the OHMedicationRequester associated with the OneHealthMedicationRequest
     */
    public function OHMedicationReqRequester(): HasOne
    {
        return $this->hasOne(OneHealthMedicationRequestRequester::class, 'one_health_medication_request_id', 'id');
    }

    /**
     * Get the OHMedicationReqReasonCode associated with the OneHealthMedicationRequest
     */
    public function OHMedicationReqReasonCode(): HasOne
    {
        return $this->hasOne(OneHealthMedicationRequestReasonCode::class, 'one_health_medication_request_id', 'id');
    }

    /**
     * Get the OHMedicationReqCourseTherapy associated with the OneHealthMedicationRequest
     */
    public function OHMedicationReqCourseTherapy(): HasOne
    {
        return $this->hasOne(OneHealthMedicationRequestCourseTherapy::class, 'one_health_medication_request_id', 'id');
    }

    /**
     * Get all of the OHMedicationReqDosageInstructions for the OneHealthMedicationRequest
     */
    public function OHMedicationReqDosageInstructions(): HasMany
    {
        return $this->hasMany(OneHealthMedicationRequestDosageInstruction::class, 'one_health_medication_request_id', 'id');
    }

    /**
     * Get the OHMedicationReqDispenseRequest associated with the OneHealthMedicationRequest
     */
    public function OHMedicationReqDispenseRequest(): HasOne
    {
        return $this->hasOne(OneHealthMedicationRequestDispenseRequest::class, 'one_health_medication_request_id', 'id');
    }

    /**
     * Get all of the OHMedicationDispenses for the OneHealthMedicationRequest
     */
    public function OHMedicationDispenses(): HasMany
    {
        return $this->hasMany(OneHealthMedicationDispense::class, 'one_health_medication_request_id', 'id');
    }
}
