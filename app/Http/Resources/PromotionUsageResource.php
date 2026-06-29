<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionUsageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'promotion_id' => $this->promotion_id,
            'customer_id' => $this->customer_id,
            'order_id' => $this->order_id,

            // Usage details
            'original_amount' => $this->original_amount,
            'discount_amount' => $this->discount_amount,
            'final_amount' => $this->final_amount,
            'savings_percentage' => $this->getSavingsPercentageAttribute(),

            // Product information
            'product_ids' => $this->product_ids,
            'quantity' => $this->quantity,

            // Timestamps
            'used_at' => $this->used_at->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),

            // Related data
            'promotion' => $this->whenLoaded('promotion', function () {
                return new PromotionResource($this->promotion);
            }),

            'customer' => $this->whenLoaded('customer', function () {
                return [
                    'id' => $this->customer->id,
                    'name' => $this->customer->name,
                    'email' => $this->customer->email,
                ];
            }),

            // Order information (if available)
            'order' => $this->when($this->order_id, function () {
                return [
                    'id' => $this->order_id,
                    'status' => $this->order?->status,
                    'total' => $this->order?->total,
                ];
            }),
        ];
    }
}
