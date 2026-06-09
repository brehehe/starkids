<?php

namespace App\Models\Promotion;

use App\Models\Company\Company;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Promotion extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'promotion_value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'minimum_purchase' => 'decimal:2',
        'maximum_purchase' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_unlimited' => 'boolean',
        'is_active' => 'boolean',
        'is_stackable' => 'boolean',
        'is_auto_apply' => 'boolean',
        'user_types' => 'array',
        'user_ids' => 'array',
        'product_ids' => 'array',
        'category_ids' => 'array',
        'branch_ids' => 'array',
        'exclude_product_ids' => 'array',
        'applicable_days' => 'array',
        'terms_conditions' => 'array',

        // Enhanced promotion fields
        'buy_products' => 'array',
        'get_products' => 'array',
        'bundle_products' => 'array',
        'bundle_price' => 'decimal:2',
        'bundle_discount' => 'decimal:2',
        'discount_tiers' => 'array',
        'product_discounts' => 'array',
        'cashback_percentage' => 'decimal:2',
        'max_cashback' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'points_multiplier' => 'decimal:2',
        'is_first_purchase_only' => 'boolean',

        // Advanced settings
        'volume_tiers' => 'array',
        'membership_levels' => 'array',
        'seasonal_conditions' => 'array',
        'usage_analytics' => 'array',
        'customer_segments' => 'array',
        'geographic_restrictions' => 'array',
        'time_restrictions' => 'array',
        'allow_combination' => 'boolean',
        'combination_rules' => 'array',
        'max_total_discount' => 'decimal:2',
        'requires_code' => 'boolean',
        'test_percentage' => 'decimal:2',
        'performance_metrics' => 'array',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'promotion_usages');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValidDate($query)
    {
        $now = Carbon::now();
        return $query->where(function ($q) use ($now) {
            $q->where('start_date', '<=', $now)
                ->where('end_date', '>=', $now);
        })->orWhere(function ($q) {
            $q->whereNull('start_date')
                ->whereNull('end_date');
        });
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    // Methods
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Check date validity
        $now = Carbon::now();
        if ($this->start_date && $this->start_date > $now) {
            return false;
        }

        if ($this->end_date && $this->end_date < $now) {
            return false;
        }

        // Check quota
        if (!$this->is_unlimited && $this->used_count >= $this->total_quota) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount, $products = []): array
    {
        if (!$this->isValid()) {
            return [
                'success' => false,
                'message' => 'Promo tidak valid',
                'discount' => 0,
                'final_amount' => $amount
            ];
        }

        if ($amount < $this->minimum_purchase) {
            return [
                'success' => false,
                'message' => "Minimal pembelian Rp " . number_format($this->minimum_purchase, 0, ',', '.'),
                'discount' => 0,
                'final_amount' => $amount
            ];
        }

        $discount = 0;

        switch ($this->type) {
            case 'percentage':
                $discount = ($amount * $this->promotion_value) / 100;
                if ($this->max_discount && $discount > $this->max_discount) {
                    $discount = $this->max_discount;
                }
                break;

            case 'fixed_amount':
                $discount = min($this->promotion_value, $amount);
                break;

            default:
                $discount = 0;
        }

        $finalAmount = max(0, $amount - $discount);

        return [
            'success' => true,
            'message' => 'Promo berhasil diterapkan',
            'discount' => $discount,
            'final_amount' => $finalAmount
        ];
    }

    // Static methods
    public static function findValidPromoByCode($code, $companyId)
    {
        return static::byCode($code)
            ->byCompany($companyId)
            ->active()
            ->validDate()
            ->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
            $modelCreate->company_id = $modelCreate->company_id ?? auth()->user()->company_id;
            $modelCreate->created_by = auth()->user()->id ?? null;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->user()->id ?? null;
        });
    }
}
