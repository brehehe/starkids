<?php

namespace App\Models\Medication\OneHealth;

use App\Models\Medication\MedicationIngredient;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OneHealthMedicationIngredient extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'strength_numerator_value' => 'int',
        'strength_denominator_value' => 'int',
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
     * Get the OHMedication that owns the OneHealthMedicationIngredient
     */
    public function OHMedication(): BelongsTo
    {
        return $this->belongsTo(OneHealthMedication::class, 'one_health_medication_id', 'id');
    }

    /**
     * Get the medictionIngredient that owns the OneHealthMedicationIngredient
     */
    public function medictionIngredient(): BelongsTo
    {
        return $this->belongsTo(MedicationIngredient::class, 'medication_ingredient_id', 'id');
    }
}
