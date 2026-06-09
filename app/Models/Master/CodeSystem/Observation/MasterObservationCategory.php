<?php

namespace App\Models\Master\CodeSystem\Observation;

use App\Models\Company\Company;
use App\Models\Observation\OneHealth\OneHealthObservationCategory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterObservationCategory extends Model
{
    //
    use SoftDeletes, HasUuids;
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
     * Get all of the OHObservationCategory for the MasterObservationCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function OHObservationCategories(): HasMany
    {
        return $this->hasMany(OneHealthObservationCategory::class, 'coding_code', 'code');
    }
}
