<?php

namespace App\Models\User;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTypeIncentive extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'price_min' => 'decimal:2',
        'price_max' => 'decimal:2',
        'incentive_value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke UserType
     */
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    /**
     * Relasi ke Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * Scope untuk filter berdasarkan company
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope untuk filter yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mencari berdasarkan range harga
     */
    public function scopeForPrice($query, $price)
    {
        return $query->where('price_min', '<=', $price)
            ->where(function ($q) use ($price) {
                $q->where('price_max', '>=', $price)
                    ->orWhereNull('price_max');
            });
    }

    /**
     * Method untuk menghitung insentif berdasarkan total transaksi
     */
    public function calculateIncentive($totalAmount)
    {
        if ($this->incentive_type === 'persen') {
            $percentage = min($this->incentive_value, 100); // Maksimal 100%
            return ($totalAmount * $percentage) / 100;
        } else {
            return $this->incentive_value;
        }
    }

    /**
     * Method untuk mendapatkan deskripsi range harga
     */
    public function getPriceRangeDescriptionAttribute()
    {
        $min = number_format($this->price_min, 0, ',', '.');

        if ($this->price_max) {
            $max = number_format($this->price_max, 0, ',', '.');
            return "Rp {$min} - Rp {$max}";
        } else {
            return "≥ Rp {$min}";
        }
    }

    /**
     * Method untuk mendapatkan deskripsi insentif
     */
    public function getIncentiveDescriptionAttribute()
    {
        if ($this->incentive_type === 'persen') {
            return $this->incentive_value . '%';
        } else {
            return 'Rp ' . number_format($this->incentive_value, 0, ',', '.');
        }
    }

    /**
     * Static method untuk mencari insentif berdasarkan user type dan total transaksi
     */
    public static function findIncentiveForUserType($userTypeId, $totalAmount, $companyId = null)
    {
        $query = static::where('user_type_id', $userTypeId)
            ->active()
            ->forPrice($totalAmount)
            ->orderBy('price_min', 'desc'); // Ambil yang range tertinggi dulu

        if ($companyId) {
            $query->byCompany($companyId);
        }

        return $query->first();
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

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('description', 'like', '%' . $search . '%')
                ->orWhereHas('userType', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        }
        return $query;
    }
}
