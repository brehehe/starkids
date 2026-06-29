<?php

namespace App\Models\Deposit;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductPackage;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositItem extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'deposit_id',
        'deposit_item_id',
        'deposit_recipe_id',
        'branch_id',
        'user_id',
        'type',
        'dosage_doctor',
        'doctor_dosage_gram',
        'dosage_drug',
        'name',
        'product_id',
        'product_package_id',
        'company_id',
        'quantity_real',
        'price',
        'price_discount',
        'price_hpp',
        'quantity',
        'discount',
        'sub_total_price',
        'sub_total_price_hpp',
        'is_narcotic',
        'is_free_item',
        'user_asign_narcotic_id',
        'type_transaction',
        'is_outside_pharmacy',
        'order',
    ];

    protected $casts = [
        'dosage_doctor' => 'decimal:2',
        'doctor_dosage_gram' => 'decimal:2',
        'dosage_drug' => 'integer',
        'quantity_real' => 'decimal:2',
        'price' => 'decimal:2',
        'price_discount' => 'decimal:2',
        'price_hpp' => 'decimal:2',
        'quantity' => 'integer',
        'discount' => 'decimal:2',
        'sub_total_price' => 'decimal:2',
        'sub_total_price_hpp' => 'decimal:2',
        'is_narcotic' => 'boolean',
        'is_free_item' => 'boolean',
        'is_outside_pharmacy' => 'boolean',
        'order' => 'integer',
    ];

    // Relations
    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }

    public function depositItem()
    {
        return $this->belongsTo(DepositItem::class, 'deposit_item_id');
    }

    public function depositRecipe()
    {
        return $this->belongsTo(DepositRecipe::class, 'deposit_recipe_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productPackage()
    {
        return $this->belongsTo(ProductPackage::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function userAssignNarcotic()
    {
        return $this->belongsTo(User::class, 'user_asign_narcotic_id');
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            'partial' => 'Partial',
            'gramasi' => 'Gramasi',
            'single' => 'Satuan',
            default => $this->type
        };
    }

    public function getTypeTransactionLabelAttribute()
    {
        return match ($this->type_transaction) {
            'medicine' => 'Obat',
            'action' => 'Tindakan',
            'recipe' => 'Resep',
            'other' => 'Lainnya',
            default => $this->type_transaction
        };
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
