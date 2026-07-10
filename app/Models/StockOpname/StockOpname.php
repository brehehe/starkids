<?php

namespace App\Models\StockOpname;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockOpname extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
        'approved_at' => 'datetime',
        'total_loss_value' => 'decimal:2',
        'total_excess_value' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function stockOpnameItems()
    {
        return $this->hasMany(StockOpnameItem::class, 'stock_opname_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->where('code', 'ilike', "%{$search}%")
                ->orWhere('date', 'ilike', "%{$search}%")
                ->orWhere('description', 'ilike', "%{$search}%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%");
                })
                ->orWhereHas('branch', function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%");
                })
                ->orWhereHas('approvedBy', function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%");
                })
                ->orWhereHas('company', function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%");
                });
        });
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
