<?php

namespace App\Models\Product;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductExpiredDate extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('batch_number', 'ilike', '%'.$search.'%')
                    ->orWhere('expired_date', 'ilike', '%'.$search.'%')
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('name', 'ilike', '%'.$search.'%');
                    });
            });
        }

        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
        });
    }
}
