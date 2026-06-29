<?php

namespace App\Models\Master\CodeSystem\Condition;

use App\Models\Condition\OneHealth\OneHealthConditionCategory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterConditionCategory extends Model
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
     * Get all of the OHConditionCategory for the MasterConditionCategory
     */
    public function OHConditionCategory(): HasMany
    {
        return $this->hasMany(OneHealthConditionCategory::class, 'coding_code', 'code');
    }
}
