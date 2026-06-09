<?php

namespace App\Models\Deposit;

use App\Models\Company\Company;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositPayment extends Model
{
    use SoftDeletes, HasUuids;

    protected $guarded = ['id'];

    protected $fillable = [
        'deposit_id',
        'user_id',
        'payment_method_id',
        'description',
        'admin_fee',
        'payment_amount',
        'payment_real',
        'is_single_payment',
        'company_id',
        'order'
    ];

    protected $casts = [
        'admin_fee' => 'decimal:2',
        'payment_amount' => 'decimal:2',
        'payment_real' => 'decimal:2',
        'is_single_payment' => 'boolean',
        'order' => 'integer'
    ];

    // Relations
    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Methods
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
            $modelCreate->company_id = $modelCreate->company_id ?? auth()->user()->company_id;
        });

        static::saved(function ($model) {
            // Recalculate deposit totals after payment is saved
            if ($model->deposit) {
                $model->deposit->calculateTotals();
            }
        });

        static::deleted(function ($model) {
            // Recalculate deposit totals after payment is deleted
            if ($model->deposit) {
                $model->deposit->calculateTotals();
            }
        });
    }
}
