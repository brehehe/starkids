<?php

namespace App\Models\Promotion;

use App\Models\Company\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PromotionEvent extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'promotions';

    protected $fillable = [
        'company_id',
        'code',
        'name',
        'description',
        'type',
        'start_date',
        'end_date',
        'discount_value',
        'minimum_purchase',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_customer',
        'used_count',
        'customer_type',
        'customer_ids',
        'applicable_to',
        'product_ids',
        'category_ids',
        'service_ids',
        'buy_quantity',
        'get_quantity',
        'get_product_id',
        'bundle_products',
        'bundle_price',
        'auto_apply',
        'is_active',
        'is_featured',
        'image',
        'terms_conditions',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'customer_ids' => 'array',
        'product_ids' => 'array',
        'category_ids' => 'array',
        'service_ids' => 'array',
        'bundle_products' => 'array',
        'terms_conditions' => 'array',
        'auto_apply' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'discount_value' => 'decimal:2',
        'minimum_purchase' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'bundle_price' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function usageHistories(): HasMany
    {
        return $this->hasMany(PromotionUsageHistory::class, 'promotion_id');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        $now = Carbon::now();
        return $query->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }

    public function scopeAvailable($query)
    {
        return $query->active()->current();
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeForCustomer($query, $customerId, $customerType = 'existing')
    {
        return $query->where(function ($q) use ($customerId, $customerType) {
            $q->where('customer_type', 'all')
                ->orWhere('customer_type', $customerType)
                ->orWhere(function ($q2) use ($customerId) {
                    $q2->where('customer_type', 'specific')
                        ->whereJsonContains('customer_ids', $customerId);
                });
        });
    }

    /**
     * Accessors & Mutators
     */
    public function getIsExpiredAttribute(): bool
    {
        return Carbon::now()->gt($this->end_date);
    }

    public function getIsNotStartedAttribute(): bool
    {
        return Carbon::now()->lt($this->start_date);
    }

    public function getIsCurrentAttribute(): bool
    {
        $now = Carbon::now();
        return $now->gte($this->start_date) && $now->lte($this->end_date);
    }

    public function getRemainingUsageAttribute(): ?int
    {
        if (!$this->usage_limit) {
            return null;
        }
        return max(0, $this->usage_limit - $this->used_count);
    }

    public function getUsagePercentageAttribute(): float
    {
        if (!$this->usage_limit) {
            return 0;
        }
        return ($this->used_count / $this->usage_limit) * 100;
    }

    /**
     * Business Logic Methods
     */
    public function canBeUsed(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->is_expired || $this->is_not_started) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function canBeUsedByCustomer($customerId): bool
    {
        if (!$this->canBeUsed()) {
            return false;
        }

        // Check customer eligibility
        if ($this->customer_type === 'specific') {
            $customerIds = $this->customer_ids ?? [];
            if (!in_array($customerId, $customerIds)) {
                return false;
            }
        }

        // Check usage limit per customer
        $customerUsageCount = $this->usageHistories()
            ->where('customer_id', $customerId)
            ->count();

        return $customerUsageCount < $this->usage_limit_per_customer;
    }

    public function calculateDiscount($orderAmount, $products = []): array
    {
        if (!$this->canBeUsed()) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Promosi tidak tersedia'
            ];
        }

        if ($orderAmount < $this->minimum_purchase) {
            return [
                'eligible' => false,
                'discount_amount' => 0,
                'message' => 'Minimal pembelian Rp ' . number_format($this->minimum_purchase, 0, ',', '.')
            ];
        }

        $discountAmount = 0;
        $message = '';

        switch ($this->type) {
            case 'percentage':
                $discountAmount = ($orderAmount * $this->discount_value) / 100;
                if ($this->maximum_discount && $discountAmount > $this->maximum_discount) {
                    $discountAmount = $this->maximum_discount;
                }
                $message = "Diskon {$this->discount_value}%";
                break;

            case 'fixed_amount':
                $discountAmount = min($this->discount_value, $orderAmount);
                $message = "Diskon Rp " . number_format($this->discount_value, 0, ',', '.');
                break;

            case 'buy_x_get_y':
                $eligibleQuantity = $this->calculateBuyXGetYDiscount($products);
                $message = "Beli {$this->buy_quantity} gratis {$this->get_quantity}";
                break;

            case 'bundle':
                if ($this->isBundleEligible($products)) {
                    $normalPrice = $this->calculateNormalBundlePrice($products);
                    $discountAmount = max(0, $normalPrice - $this->bundle_price);
                    $message = "Paket hemat bundle";
                }
                break;

            default:
                $message = "Jenis promosi tidak dikenali";
                break;
        }

        return [
            'eligible' => $discountAmount > 0,
            'discount_amount' => $discountAmount,
            'final_amount' => max(0, $orderAmount - $discountAmount),
            'message' => $message
        ];
    }

    private function calculateBuyXGetYDiscount($products): int
    {
        // Implementation for Buy X Get Y logic
        if (!$this->buy_quantity || !$this->get_quantity) {
            return 0;
        }

        $applicableProducts = collect($products)->filter(function ($product) {
            if ($this->applicable_to === 'all_products') {
                return true;
            }

            if ($this->applicable_to === 'specific_products') {
                return in_array($product['id'], $this->product_ids ?? []);
            }

            return false;
        });

        $totalQuantity = $applicableProducts->sum('quantity');
        $freeItems = intval($totalQuantity / $this->buy_quantity) * $this->get_quantity;

        return $freeItems;
    }

    private function isBundleEligible($products): bool
    {
        $bundleProducts = $this->bundle_products ?? [];
        $productIds = collect($products)->pluck('id')->toArray();

        foreach ($bundleProducts as $bundleProduct) {
            if (!in_array($bundleProduct['product_id'], $productIds)) {
                return false;
            }
        }

        return count($bundleProducts) > 0;
    }

    private function calculateNormalBundlePrice($products): float
    {
        $bundleProducts = $this->bundle_products ?? [];
        $totalPrice = 0;

        foreach ($bundleProducts as $bundleProduct) {
            $product = collect($products)->firstWhere('id', $bundleProduct['product_id']);
            if ($product) {
                $totalPrice += $product['price'] * $bundleProduct['quantity'];
            }
        }

        return $totalPrice;
    }

    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    public function recordUsage($customerId, $orderAmount, $discountAmount, $appliedProducts = [], $orderId = null): PromotionUsageHistory
    {
        $this->incrementUsage();

        return $this->usageHistories()->create([
            'customer_id' => $customerId,
            'order_id' => $orderId,
            'order_amount' => $orderAmount,
            'discount_amount' => $discountAmount,
            'applied_products' => $appliedProducts,
            'used_at' => Carbon::now(),
        ]);
    }
}
