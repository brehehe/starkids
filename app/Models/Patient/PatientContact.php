<?php

namespace App\Models\Patient;

use App\Models\Master\CodeSystem\Patient\MasterPatientContactRelationship;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientContact extends Model
{
    //
    use HasFactory, HasUuids, SoftDeletes;

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
     * Get the patient that owns the PatientContact
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    /**
     * Get the relationshipCodingCode that owns the PatientContact
     */
    public function relationshipCodingCode(): BelongsTo
    {
        return $this->belongsTo(MasterPatientContactRelationship::class, 'relationship_coding_code', 'code');
    }
}
