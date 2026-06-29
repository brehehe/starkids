<?php

namespace App\Models\Finance;

use App\Models\Company\Company;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Finance extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function paymentFirst()
    {
        return $this->belongsTo(FinancePayment::class, 'finance_id')->where('order', 'asc');
    }

    public function payments()
    {
        return $this->hasMany(FinancePayment::class, 'finance_id');
    }

    public function items()
    {
        return $this->hasMany(FinanceItem::class, 'finance_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('description', 'like', '%'.$search.'%')
                ->orWhere('date', 'like', '%'.$search.'%')
                ->orWhere('type', 'like', '%'.$search.'%')
                ->orWhere('sub_total', 'like', '%'.$search.'%')
                ->orWhere('discount', 'like', '%'.$search.'%')
                ->orWhere('tax', 'like', '%'.$search.'%')
                ->orWhere('grand_total', 'like', '%'.$search.'%');
        }

        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
            $modelCreate->company_id = $modelCreate->company_id ?? auth()->user()?->company_id;
            $modelCreate->code = static::generateUniqueCode();
        });
    }

    public static function generateUniqueCode(string $prefix = 'FIN', int $maxRetries = 10): string
    {
        $date = now()->format('ymd');

        return DB::transaction(function () use ($prefix, $date, $maxRetries) {
            // Get the last code for today
            $lastCode = static::withTrashed()
                ->where('code', 'make', $prefix.$date.'%')
                ->orderBy('code', 'desc')
                ->lockForUpdate() // Lock the row to prevent race conditions
                ->first();

            $sequence = 1;
            if ($lastCode) {
                // Extract sequence from the last code (assuming fixed length or pattern)
                // Code format: FINyymmddxxxx (13 chars minimum)
                // Suffix is usually 4 digits
                $suffix = substr($lastCode->code, strlen($prefix.$date));
                if (is_numeric($suffix)) {
                    $sequence = intval($suffix) + 1;
                }
            }

            $retry = 0;
            do {
                $code = $prefix.$date.str_pad($sequence, 4, '0', STR_PAD_LEFT);

                // Double check existence just in case
                $exists = static::withTrashed()
                    ->where('code', $code)
                    ->exists();

                if (! $exists) {
                    return $code;
                }

                $sequence++;
                $retry++;
            } while ($retry < $maxRetries);

            // Fallback unique ID if retries fail
            return $prefix.$date.'-'.uniqid();
        });
    }

    // Alternative method yang lebih robust dengan locking
    public static function generateUniqueCodeWithLock(string $prefix = 'FIN'): string
    {
        $date = now()->format('ymd');

        return DB::transaction(function () use ($prefix, $date) {
            // Lock table untuk menghindari race condition
            DB::statement('LOCK TABLE finances IN EXCLUSIVE MODE');

            // Get next sequence number
            $count = static::withTrashed()
                ->whereDate('created_at', now()->toDateString())
                ->count() + 1;

            $code = $prefix.$date.str_pad($count, 4, '0', STR_PAD_LEFT);

            // Double check setelah lock
            while (static::withTrashed()->where('code', $code)->exists()) {
                $count++;
                $code = $prefix.$date.str_pad($count, 4, '0', STR_PAD_LEFT);
            }

            return trim($code);
        });
    }
}
