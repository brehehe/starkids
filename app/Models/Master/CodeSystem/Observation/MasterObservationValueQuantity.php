<?php

namespace App\Models\Master\CodeSystem\Observation;

use App\Models\Observation\OneHealth\OneHealthObservationValueQuantity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterObservationValueQuantity extends Model
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
     * Get all of the OHObservationValueQuantities for the MasterObservationValueQuantity
     */
    public function OHObservationValueQuantities(): HasMany
    {
        return $this->hasMany(OneHealthObservationValueQuantity::class, 'code', 'code');
    }
}
