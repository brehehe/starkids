<?php

namespace App\Models\Location\OneHealth;

use App\Models\Company\OneHealth\OneHealthOrganization;
use App\Models\Encounter\OneHealth\OneHealthEncounterLocation;
use App\Models\Location\Location;
use App\Models\Master\CodeSystem\Location\MasterLocationMode;
use App\Models\Master\CodeSystem\Location\MasterLocationStatus;
use App\Models\Master\CodeSystem\Location\MasterLocationType;
use App\Models\MedicationDispense\OneHealth\OneHealthMedicationDispense;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class OneHealthLocation extends Model
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

                $model->updateOrCreateType();
                $model->updateOrCreateCoordinate();
                $model->updateOrCreateTelecoms($model);
                $model->updateOrCreateAddress($model);
                $model->updateOrCreateIdentifier();

            } catch (Exception|Throwable $th) {
                DB::rollBack();
                $error = [
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                ];

                Log::error('Ada kesalahan saat boot OneHealthLocation', $error);
            }
        });
    }

    /**
     * Get the location that owns the OneHealthLocation
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    /**
     * Get the OHOrganization that owns the OneHealthLocation
     */
    public function OHOrganization(): BelongsTo
    {
        return $this->belongsTo(OneHealthOrganization::class, 'one_health_organization_id', 'id');
    }

    /**
     * Get the OHLIdentifier associated with the OneHealthLocation
     */
    public function OHLIdentifier(): HasOne
    {
        return $this->hasOne(OneHealthLocationIdentifier::class, 'one_health_location_id', 'id');
    }

    public function updateOrCreateIdentifier()
    {
        $this->OHLIdentifier()->updateOrCreate([
            'value' => $this->id,
        ]);
    }

    /**
     * Get the status that owns the OneHealthLocation
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(MasterLocationStatus::class, 'status', 'code');
    }

    /**
     * Get the mode that owns the OneHealthLocation
     */
    public function mode(): BelongsTo
    {
        return $this->belongsTo(MasterLocationMode::class, 'mode', 'code');
    }

    /**
     * Get all of the OHLocationTelecoms for the OneHealthLocation
     */
    public function OHLocationTelecoms(): HasMany
    {
        return $this->hasMany(OneHealthLocationTelecom::class, 'one_health_location_id', 'id');
    }

    public function updateOrCreateTelecoms($model)
    {
        $telecoms = $model?->OHOrganization?->OHOrganizationTelecoms ?? [];
        foreach ($telecoms as $key => $telecom) {
            $model->OHLocationTelecoms()->updateOrCreate(
                [
                    'system' => $telecom?->system,
                ],
                [
                    'value' => $telecom?->value,
                ]
            );
        }
    }

    /**
     * Get the OHLocationAddress associated with the OneHealthLocation
     */
    public function OHLocationAddress(): HasOne
    {
        return $this->hasOne(OneHealthLocationAddress::class, 'one_health_location_id', 'id');
    }

    public function updateOrCreateAddress($model)
    {
        $address = $model?->OHOrganization?->OHOrganizationAddress;
        $model->OHLocationAddress()->updateOrCreate(
            [
                'one_health_location_id' => $model?->id,
            ],
            [
                'use' => $address?->use ?? 'work',
                'line' => $address?->line,
                'city' => $address?->city,
                'postal_code' => $address?->postal_code,
                'country' => $address?->country,
            ]
        );
    }

    /**
     * Get the asd that owns the OneHealthLocation
     */
    public function physicalType(): BelongsTo
    {
        return $this->belongsTo(MasterLocationType::class, 'physicalType_coding_code', 'code');
    }

    public function updateOrCreateType()
    {
        $this->updateQuietly(
            [
                'physicalType_coding_code' => $this?->physicalType?->code,
                'physicalType_coding_display' => $this?->physicalType?->display,
            ]
        );
    }

    public function updateOrCreateCoordinate()
    {
        $this->updateQuietly(
            [
                'position_longitude' => $this?->OHOrganization?->company?->companyDetail?->longitude ?? 0,
                'position_latitude' => $this?->OHOrganization?->company?->companyDetail?->latitude ?? 0,
                'position_altitude' => $this?->OHOrganization?->company?->companyDetail?->altitude ?? 0,
            ]
        );
    }

    /**
     * Get all of the OHEncounterLocations for the OneHealthLocation
     */
    public function OHEncounterLocations(): HasMany
    {
        return $this->hasMany(OneHealthEncounterLocation::class, 'one_health_location_id', 'id');
    }

    /**
     * Get all of the OHMedicationDispenses for the OneHealthLocation
     */
    public function OHMedicationDispenses(): HasMany
    {
        return $this->hasMany(OneHealthMedicationDispense::class, 'one_health_location_id', 'id');
    }
}
