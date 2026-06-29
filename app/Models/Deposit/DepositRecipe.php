<?php

namespace App\Models\Deposit;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\HowToUse\HowToUse;
use App\Models\MedicineType\MedicineType;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositRecipe extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'recipe_id',
        'medicine_type_id',
        'branch_id',
        'numero_recipe',
        'price_service_one',
        'price_service_other',
        'product_id',
        'quantity',
        'price',
        'price_discount',
        'price_hpp',
        'sub_total_price',
        'sub_total_price_hpp',
        'how_to_use_id',
        'description',
        'route_coding_code',
        'company_id',
        'order',
    ];

    protected $casts = [
        'numero_recipe' => 'integer',
        'price_service_one' => 'decimal:2',
        'price_service_other' => 'decimal:2',
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'price_discount' => 'decimal:2',
        'price_hpp' => 'decimal:2',
        'sub_total_price' => 'decimal:2',
        'sub_total_price_hpp' => 'decimal:2',
        'order' => 'integer',
    ];

    public function medicineType()
    {
        return $this->belongsTo(MedicineType::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function howToUse()
    {
        return $this->belongsTo(HowToUse::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'recipe_id');
    }

    // Methods
    public function calculateSubTotal()
    {
        $priceAfterDiscount = $this->price - $this->price_discount;
        $this->sub_total_price = $priceAfterDiscount * $this->quantity;
        $this->sub_total_price_hpp = $this->price_hpp * $this->quantity;
        $this->save();
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
}
