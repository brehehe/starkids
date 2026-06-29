<?php

namespace App\Models\Location\OneHealth;

use App\Models\Master\CodeSystem\Location\MasterLocationAddressUse;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class OneHealthLocationAddress extends Model
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
        static::saved(function ($model) {
            try {
                // Force commit any pending transactions before proceeding
                $initialTransactionLevel = DB::transactionLevel();
                if ($initialTransactionLevel > 0) {

                    while (DB::transactionLevel() > 0) {
                        DB::commit();
                    }
                }

                $model->updateOrCreateExtention();

            } catch (Exception|Throwable $th) {
                DB::rollBack();
                $error = [
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                ];

                Log::error('Ada kesalahan saat boot OneHealthLocationAddress', $error);
            }
        });
    }

    /**
     * Get the OHLocation that owns the OneHealthLocationAddress
     */
    public function OHLocation(): BelongsTo
    {
        return $this->belongsTo(OneHealthLocation::class, 'one_health_location_id', 'id');
    }

    /**
     * Get the addressUse that owns the OneHealthLocationAddress
     */
    public function use(): BelongsTo
    {
        return $this->belongsTo(MasterLocationAddressUse::class, 'use', 'code');
    }

    /**
     * Get all of the extentions for the OneHealthLocationAddress
     */
    public function extentions(): HasMany
    {
        return $this->hasMany(OneHealthLocationAddressExtention::class, 'one_health_location_address_id', 'id');
    }

    public function updateOrCreateExtention()
    {
        $extentions = $this?->OHLocation?->OHOrganization?->OHOrganizationAddress?->extentions ?? [];
        // dd($this?->OHLocation?->OHOrganization?->OHOrganizationAddress?->extentions);
        foreach ($extentions as $key => $extention) {
            $this->extentions()->updateOrCreate(
                [
                    'url' => $extention?->url,
                ],
                [
                    'value_code' => $extention?->value_code,
                ]
            );
        }
    }
}
