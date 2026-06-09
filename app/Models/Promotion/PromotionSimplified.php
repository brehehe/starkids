<?php

namespace App\Models\Promotion;

use App\Models\Company\Company;
use App\Models\User;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PromotionSimplified extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'promotion_simplified';
    protected $guarded = ['id'];

    protected $casts = [
        // Basic
        'discount_value'      => 'decimal:2',
        'max_discount'        => 'decimal:2',
        'minimum_purchase'    => 'decimal:2',
        'bundle_price'        => 'decimal:2',
        'cashback_percentage' => 'decimal:2',
        'points_multiplier'   => 'integer', // di migration pakai integer

        // Time
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',

        // Boolean
        'is_unlimited'     => 'boolean',
        'is_active'        => 'boolean',
        'apply_time_to_days' => 'boolean',
        'is_featured'      => 'boolean',
        'can_combine_with_other' => 'boolean',

        // JSON fields
        'bundle_products'      => 'array',
        'applicable_products'  => 'array',
        'applicable_users'     => 'array',
        'applicable_user_types' => 'array',
        'applicable_companies' => 'array',
        'applicable_days'      => 'array',
        'specific_days'        => 'array',
        'terms_conditions'     => 'array',
        'buy_x_get_y_rules'    => 'array',
        'discount_products'    => 'array',
    ];

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'discount_type',
        'discount_value',
        'max_discount',
        'minimum_purchase',
        'buy_quantity',
        'get_quantity',
        'buy_product_id',
        'get_product_id',
        'bundle_price',
        'bundle_products',
        'special_type',
        'cashback_percentage',
        'max_cashback',
        'free_shipping_min',
        'points_multiplier',
        'target_type',
        'selected_products',
        'selected_users',
        'selected_companies',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'applicable_days',
        'applicable_products',
        'applicable_user_types',
        'applicable_users',
        'applicable_companies',
        'terms_conditions',
        'schedule_type',
        'specific_days',
        'specific_start_time',
        'specific_end_time',
        'apply_time_to_days',
        'buy_x_get_y_rules',
        'discount_products',
        'total_quota',
        'quota_per_user',
        'used_count',
        'is_unlimited',
        'is_active',
        'priority',
        'banner_text',
        'image',
        'created_by',
        'updated_by',
        'company_id',
        'is_featured',
        'can_combine_with_other',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function buyProduct()
    {
        return $this->belongsTo(Product::class, 'buy_product_id');
    }

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'get_product_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'promotion_products', 'promotion_id', 'product_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'promotion_users', 'promotion_id', 'user_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInDateRange($query)
    {
        $now = Carbon::now();
        return $query->where(function ($q) use ($now) {
            $q->whereNull('start_date')
                ->orWhere('start_date', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('end_date')
                ->orWhere('end_date', '>=', $now);
        });
    }

    public function scopeInTimeRange($query)
    {
        $now = Carbon::now()->format('H:i:s');
        return $query->where(function ($q) use ($now) {
            $q->whereNull('start_time')
                ->orWhere('start_time', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('end_time')
                ->orWhere('end_time', '>=', $now);
        });
    }

    public function scopeForToday($query)
    {
        $today = strtolower(Carbon::now()->format('l'));
        return $query->where(function ($q) use ($today) {
            $q->whereNull('applicable_days')
                ->orWhereJsonContains('applicable_days', $today);
        });
    }

    public function scopeHasQuota($query)
    {
        return $query->where(function ($q) {
            $q->where('is_unlimited', true)
                ->orWhereColumn('used_count', '<', 'total_quota');
        });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Helper Methods
    public function isValid()
    {
        return $this->is_active
            && $this->isInDateRange()
            && $this->isInTimeRange()
            && $this->isApplicableToday()
            && $this->hasQuota();
    }

    public function isInDateRange()
    {
        $now = Carbon::now();

        if ($this->start_date && $this->start_date > $now) {
            return false;
        }

        if ($this->end_date && $this->end_date < $now) {
            return false;
        }

        return true;
    }

    public function isInTimeRange()
    {
        if (!$this->start_time && !$this->end_time) {
            return true;
        }

        $now = Carbon::now()->format('H:i:s');

        if ($this->start_time && $this->start_time > $now) {
            return false;
        }

        if ($this->end_time && $this->end_time < $now) {
            return false;
        }

        return true;
    }

    public function isApplicableToday()
    {
        if (!$this->applicable_days) {
            return true;
        }

        $today = strtolower(Carbon::now()->format('l'));
        return in_array($today, $this->applicable_days);
    }

    public function hasQuota()
    {
        if ($this->is_unlimited) {
            return true;
        }

        return $this->used_count < $this->total_quota;
    }

    public function canUserUse($userId)
    {
        if ($this->quota_per_user <= 0) {
            return true;
        }

        // Check how many times this user has used this promotion
        $userUsageCount = PromotionUsage::where('promotion_id', $this->id)
            ->where('user_id', $userId)
            ->count();

        return $userUsageCount < $this->quota_per_user;
    }

    public function incrementUsage($userId = null)
    {
        $this->increment('used_count');

        if ($userId) {
            PromotionUsage::create([
                'promotion_id' => $this->id,
                'user_id' => $userId,
                'promotion_code' => $this->code,
                'used_at' => Carbon::now()
            ]);
        }
    }

    public function calculateDiscount($originalPrice)
    {
        if ($this->type !== 'discount') {
            return 0;
        }

        switch ($this->discount_type) {
            case 'percentage':
                $discount = ($originalPrice * $this->discount_value) / 100;
                if ($this->max_discount && $discount > $this->max_discount) {
                    $discount = $this->max_discount;
                }
                return $discount;

            case 'fixed':
                return min($this->discount_value, $originalPrice);

            case 'fixed_price':
                return max(0, $originalPrice - $this->discount_value);

            default:
                return 0;
        }
    }

    public function getFinalPrice($originalPrice)
    {
        if ($this->type !== 'discount') {
            return $originalPrice;
        }

        if ($this->discount_type === 'fixed_price') {
            return $this->discount_value;
        }

        $discount = $this->calculateDiscount($originalPrice);
        return max(0, $originalPrice - $discount);
    }

    public function getDiscountText()
    {
        switch ($this->type) {
            case 'discount':
                switch ($this->discount_type) {
                    case 'percentage':
                        $text = "{$this->discount_value}% OFF";
                        if ($this->max_discount) {
                            $text .= " (Maks. Rp " . number_format($this->max_discount, 0, ',', '.') . ")";
                        }
                        return $text;

                    case 'fixed':
                        return "Rp " . number_format($this->discount_value, 0, ',', '.') . " OFF";

                    case 'fixed_price':
                        return "Harga Spesial Rp " . number_format($this->discount_value, 0, ',', '.');
                }
                break;

            case 'buy_x_get_y':
                return "Beli {$this->buy_quantity} Gratis {$this->get_quantity}";

            case 'bundle':
                return "Paket Bundle Rp " . number_format($this->bundle_price, 0, ',', '.');

            case 'special':
                switch ($this->special_type) {
                    case 'cashback':
                        $text = "Cashback {$this->cashback_percentage}%";
                        if ($this->max_cashback) {
                            $text .= " (Maks. Rp " . number_format($this->max_cashback, 0, ',', '.') . ")";
                        }
                        return $text;

                    case 'free_shipping':
                        return "Gratis Ongkir min. Rp " . number_format($this->free_shipping_min, 0, ',', '.');

                    case 'loyalty_points':
                        return "Poin {$this->points_multiplier}x Lipat";
                }
                break;
        }

        return $this->name;
    }

    // Static helper methods
    public static function getActivePromotions($companyId = null)
    {
        $query = self::active()
            ->inDateRange()
            ->inTimeRange()
            ->forToday()
            ->hasQuota()
            ->orderBy('priority', 'desc');

        if ($companyId) {
            $query->byCompany($companyId);
        }

        return $query->get();
    }

    public static function findByCode($code, $companyId = null)
    {
        $query = self::where('code', $code)->active();

        if ($companyId) {
            $query->byCompany($companyId);
        }

        return $query->first();
    }
}
