<?php

namespace App\Models\Observation\OneHealth;

use App\Models\Company\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Observation\OneHealth\OneHealthObservation;
use App\Models\Master\CodeSystem\Observation\MasterObservationCode;

class OneHealthObservationCode extends Model
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
            $modelCreate->coding_display = $modelCreate?->code?->display;
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
                'coding_display' => $model?->code?->display
            ]);
        });
    }

    /**
     * Get the OHObservation that owns the OneHealthObservationCode
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function OHObservation(): BelongsTo
    {
        return $this->belongsTo(OneHealthObservation::class, 'one_health_observation_id', 'id');
    }

    /**
     * Get the code that owns the OneHealthObservationCode
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function code(): BelongsTo
    {
        return $this->belongsTo(MasterObservationCode::class, 'coding_code', 'code');
    }
}
