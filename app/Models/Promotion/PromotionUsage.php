<?php

namespace App\Models\Promotion;

use App\Models\Company\Company;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PromotionUsage extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'original_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'applied_products' => 'array',
        'used_at' => 'datetime',
    ];

    // Relationships
    public function promotion()
    {
        return $this->belongsTo(PromotionSimplified::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Scopes
    public function scopeByPromotion($query, $promotionId)
    {
        return $query->where('promotion_id', $promotionId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Methods
    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'notes' => $reason
        ]);

        // Decrement usage count on promotion
        $this->promotion->decrement('used_count');
    }

    public function refund($reason = null)
    {
        $this->update([
            'status' => 'refunded',
            'notes' => $reason
        ]);

        // Decrement usage count on promotion
        $this->promotion->decrement('used_count');
    }
}
