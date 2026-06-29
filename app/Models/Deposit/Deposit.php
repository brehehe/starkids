<?php

namespace App\Models\Deposit;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\User;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $fillable = [
        'code',
        'patient_id',
        'user_type_id',
        'patient_company_role_id',
        'text',
        'description',
        'quantity_request',
        'quantity_free',
        'quantity',
        'remaining_quantity',
        'sub_total_price',
        'grand_total_price',
        'remaining_bill',
        'payment_change',
        'status',
        'created_by',
        'branch_id',
        'company_id',
        'order',
    ];

    protected $casts = [
        'quantity_request' => 'decimal:0',
        'quantity_free' => 'decimal:0',
        'quantity' => 'decimal:0',
        'remaining_quantity' => 'decimal:0',
        'sub_total_price' => 'decimal:2',
        'grand_total_price' => 'decimal:2',
        'remaining_bill' => 'decimal:2',
        'payment_change' => 'decimal:2',
        'order' => 'integer',
    ];

    // Relations
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    public function patientCompanyRole()
    {
        return $this->belongsTo(UserCompanyRole::class, 'patient_company_role_id');
    }

    public function depositPayments()
    {
        return $this->hasMany(DepositPayment::class);
    }

    public function depositItems()
    {
        return $this->hasMany(DepositItem::class);
    }

    public function depositRecipes()
    {
        return $this->hasMany(DepositRecipe::class, 'recipe_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    // Accessors
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'waiting' => 'Menunggu',
            'partial' => 'Sebagian',
            'success' => 'Selesai',
            default => $this->status
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'waiting' => 'bg-warning text-dark',
            'partial' => 'bg-info text-white',
            'success' => 'bg-success text-white',
            default => 'bg-secondary text-white'
        };
    }

    // Methods
    public static function generateCode()
    {
        $prefix = 'DEP';
        $date = now()->format('ymd');
        $count = static::whereDate('created_at', now())->count() + 1;

        return $prefix.$date.str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotals()
    {
        $items = $this->depositItems;
        $this->sub_total_price = $items->sum('sub_total_price');
        $this->quantity = $items->sum('quantity');
        $this->grand_total_price = $this->sub_total_price;

        $totalPayments = $this->depositPayments->sum('payment_real');
        $this->remaining_bill = $this->grand_total_price - $totalPayments;

        if ($this->remaining_bill <= 0) {
            $this->status = 'success';
            $this->payment_change = abs($this->remaining_bill);
            $this->remaining_bill = 0;
        } elseif ($totalPayments > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'waiting';
        }

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
