<?php

namespace App\Models\Observation\OneHealth;

use App\Models\Master\CodeSystem\Observation\MasterObservationValueQuantity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OneHealthObservationValueQuantity extends Model
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
            $modelCreate->unit = $modelCreate?->codeValue?->display;
        });

        static::saved(function ($model) {

            // Force commit any pending transactions before proceeding
            $initialTransactionLevel = DB::transactionLevel();
            if ($initialTransactionLevel > 0) {

                while (DB::transactionLevel() > 0) {
                    DB::commit();
                }
            }

            $model->updateQuietly([
                'unit' => $model?->codeValue?->display,
            ]);
        });
    }

    /**
     * Get the OHObservation that owns the OneHealthObservationValueQuantity
     */
    public function OHObservation(): BelongsTo
    {
        return $this->belongsTo(OneHealthObservation::class, 'one_health_observation_id', 'id');
    }

    /**
     * Get the code that owns the OneHealthObservationValueQuantity
     */
    public function codeValue(): BelongsTo
    {
        return $this->belongsTo(MasterObservationValueQuantity::class, 'code', 'code');
    }
}
