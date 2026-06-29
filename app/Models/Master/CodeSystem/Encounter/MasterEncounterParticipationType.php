<?php

namespace App\Models\Master\CodeSystem\Encounter;

use App\Models\Encounter\Onehealth\OneHealthEnconterParticipant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterEncounterParticipationType extends Model
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
     * Get all of the OHEncounterParticipants for the MasterEncounterParticipationType
     */
    public function OHEncounterParticipants(): HasMany
    {
        return $this->hasMany(OneHealthEnconterParticipant::class, 'type_coding_code', 'code');
    }
}
