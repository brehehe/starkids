<?php

namespace App\Models\StockMutation;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMutation extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function companyMain()
    {
        return $this->belongsTo(Company::class, 'company_main_id');
    }

    public function companyBranch()
    {
        return $this->belongsTo(Company::class, 'company_branch_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('code', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%')
                ->orWhereHas('company', function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%');
                })->orWhereHas('companyMain', function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%');
                })->orWhereHas('companyBranch', function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%');
                });
        });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
            $modelCreate->company_id = $modelCreate->company_id ?? auth()->user()->company_id;
        });
    }
}
