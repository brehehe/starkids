<?php

namespace App\Models\Promotion;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionUsageHistory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'promotion_id',
        'customer_id',
        'order_id',
        'order_amount',
        'discount_amount',
        'applied_products',
        'used_at',
    ];

    protected $casts = [
        'order_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'applied_products' => 'array',
        'used_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function promotion(): BelongsTo
    {
        return $this->belongsTo(PromotionEvent::class, 'promotion_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Scopes
     */
    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeByPromotion($query, $promotionId)
    {
        return $query->where('promotion_id', $promotionId);
    }

    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('used_at', [$startDate, $endDate]);
    }
}
