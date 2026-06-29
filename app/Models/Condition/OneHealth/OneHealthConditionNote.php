<?php

namespace App\Models\Condition\OneHealth;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OneHealthConditionNote extends Model
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
     * Get the OHCondition that owns the OneHealthConditionNote
     */
    public function OHCondition(): BelongsTo
    {
        return $this->belongsTo(OneHealthCondition::class, 'one_health_condition_id', 'id');
    }
}
