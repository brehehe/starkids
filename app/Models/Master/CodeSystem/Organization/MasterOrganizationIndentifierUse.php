<?php

namespace App\Models\Master\CodeSystem\Organization;

use App\Models\Company\OneHealth\OneHealthOrganizationIdentifier;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterOrganizationIndentifierUse extends Model
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
     * Get the OHOrganizationIdentifier that owns the MasterOrganizationIndentifierUse
     */
    public function OHOrganizationIdentifier(): HasMany
    {
        return $this->hasMany(OneHealthOrganizationIdentifier::class, 'use', 'code');
    }
}
