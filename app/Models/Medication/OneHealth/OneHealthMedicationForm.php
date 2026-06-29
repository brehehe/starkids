<?php

namespace App\Models\Medication\OneHealth;

use App\Models\Master\CodeSystem\Medication\MasterMedicationForm;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OneHealthMedicationForm extends Model
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
            $modelCreate->setAutomatic();
        });
        static::saved(function ($model) {
            $model->setAutomatic();
        });
    }

    /**
     * Get the OHMedication that owns the OneHealthMedicationFormCoding
     */
    public function OHMedication(): BelongsTo
    {
        return $this->belongsTo(OneHealthMedication::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get the masterForm that owns the OneHealthMedicationForm
     */
    public function masterForm(): BelongsTo
    {
        return $this->belongsTo(MasterMedicationForm::class, 'code', 'code');
    }

    public function setAutomatic()
    {
        $this->updateQuietly([
            'display' => $this->masterForm->display,
        ]);
    }
}
