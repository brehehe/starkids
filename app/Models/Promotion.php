<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'buy_products' => 'array',
        'get_products' => 'array',
        'bundle_products' => 'array',
        'discount_tiers' => 'array',
        'product_discounts' => 'array',
        'target_categories' => 'array',
        'target_users' => 'array',
        'free_shipping_threshold' => 'decimal:2',
        'cashback_percentage' => 'decimal:2',
        'max_cashback' => 'decimal:2',
        'bundle_price' => 'decimal:2',
        'bundle_discount' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'points_multiplier' => 'decimal:1',
        'is_first_purchase_only' => 'boolean',
        'applies_to_discounted_items' => 'boolean',
        'is_stackable' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function isValid()
    {
        return $this->is_active
            && $this->start_date <= now()
            && $this->end_date >= now()
            && (! $this->max_usage || $this->current_usage < $this->max_usage);
    }

    public function canBeUsedBy($userId)
    {
        // Check if user has reached max usage per user
        if ($this->max_usage_per_user) {
            // This would need to check against a promotion_usage table
            // For now, return true
            return true;
        }

        // Check if promotion is for first-time buyers only
        if ($this->is_first_purchase_only) {
            // This would need to check user's purchase history
            // For now, return true
            return true;
        }

        // Check if user is in target users list
        if ($this->target_users && ! in_array($userId, $this->target_users)) {
            return false;
        }

        return true;
    }

    public function incrementUsage()
    {
        $this->increment('current_usage');
    }

    public function getDescription()
    {
        switch ($this->type) {
            case 'buy_x_get_y':
                if ($this->buy_get_mode === 'same_product') {
                    return "Beli {$this->buy_quantity} Gratis {$this->get_quantity}";
                } else {
                    return 'Beli produk tertentu, dapatkan produk gratis/diskon';
                }

            case 'bundle':
                return 'Paket Bundle - Hemat dengan membeli produk dalam satu paket';

            case 'cashback':
                return "Cashback {$this->cashback_percentage}%".
                    ($this->max_cashback ? ' (Max Rp '.number_format($this->max_cashback).')' : '');

            case 'minimum_purchase_discount':
                return 'Diskon bertingkat berdasarkan total pembelian';

            case 'free_shipping':
                return 'Gratis ongkir untuk pembelian min Rp '.number_format($this->free_shipping_threshold ?? 0);

            case 'loyalty_points':
                return 'Dapatkan poin loyalitas '.($this->points_multiplier ?? 1).'x lipat';

            default:
                return $this->name;
        }
    }
}
