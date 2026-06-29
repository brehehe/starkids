<?php

namespace App\Models\Product;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'hpp_average' => 'decimal:2',
        'hpp_average_generate' => 'decimal:2',
        'price_generate' => 'decimal:2',
        'price' => 'decimal:2',
        'recipe_generate' => 'decimal:2',
        'recipe' => 'decimal:2',
        'is_updated' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
        });
    }

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
        return $query->where(function ($query) use ($search) {
            $query
                ->where('hpp_average', 'ilike', "%{$search}%")
                ->orWhere('price', 'ilike', "%{$search}%")
                ->orWhere('recipe', 'ilike', "%{$search}%")
                ->orWhereHas('product', function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('sku_number', 'ilike', "%{$search}%");
                })
                ->orWhereHas('product.productType', function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%");
                })
                ->orWhereHas('branch', function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%");
                })
                ->orWhereHas('company', function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%");
                });
        });
    }

    // Additional Scopes
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Methods for Promotion Integration
    public function getDiscountedPrice($promotionDiscount = 0, $discountType = 'percentage')
    {
        $originalPrice = $this->price;

        if ($discountType === 'percentage') {
            $discountAmount = ($originalPrice * $promotionDiscount) / 100;

            return max(0, $originalPrice - $discountAmount);
        } elseif ($discountType === 'fixed_amount') {
            return max(0, $originalPrice - $promotionDiscount);
        } elseif ($discountType === 'fixed_price') {
            return max(0, $promotionDiscount);
        }

        return $originalPrice;
    }

    public function calculateProfit($sellingPrice = null)
    {
        $sellingPrice = $sellingPrice ?? $this->price;

        return $sellingPrice - $this->hpp_average;
    }

    public function getProfitMargin($sellingPrice = null)
    {
        $sellingPrice = $sellingPrice ?? $this->price;
        if ($sellingPrice <= 0) {
            return 0;
        }

        $profit = $this->calculateProfit($sellingPrice);

        return ($profit / $sellingPrice) * 100;
    }

    // Static methods for promotion system
    public static function getProductPrice($productId, $branchId = null, $companyId = null)
    {
        $query = static::where('product_id', $productId);

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        return $query->first();
    }

    public static function updatePrice($productId, $branchId, $price, $companyId = null)
    {
        $productPrice = static::firstOrCreate([
            'product_id' => $productId,
            'branch_id' => $branchId,
            'company_id' => $companyId ?? auth()->user()->company_id,
        ]);

        $productPrice->update([
            'price' => $price,
            'is_updated' => true,
        ]);

        return $productPrice;
    }
}
