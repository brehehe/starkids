<?php

namespace App\Models\Transaction;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    //
    use SoftDeletes, HasUuids;
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function transactionRecipe()
    {
        return $this->belongsTo(TransactionRecipe::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function nurse()
    {
        return $this->belongsTo(\App\Models\User::class, 'nurse_id');
    }

    public function doctor()
    {
        return $this->belongsTo(\App\Models\User::class, 'doctor_id');
    }

    // Parent-child relationships for Buy X Get Y promotions
    public function parentDetail()
    {
        return $this->belongsTo(TransactionDetail::class, 'transaction_detail_id');
    }

    public function childDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_detail_id');
    }

    // Check if this is a free item from promotion
    public function isFreeItem()
    {
        return !is_null($this->transaction_detail_id);
    }

    // Check if this is a main item that can have free items
    public function isMainItem()
    {
        return is_null($this->transaction_detail_id);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
            $modelCreate->company_id = $modelCreate->company_id ?? auth()->user()->company_id;
            $modelCreate->branch_id = Branch::where('company_id', $modelCreate->company_id)
                ->value('id');
        });
    }
}
