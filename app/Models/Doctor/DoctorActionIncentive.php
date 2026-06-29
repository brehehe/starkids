<?php

namespace App\Models\Doctor;

use App\Models\Product\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorActionIncentive extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * user_id = doctor's user ID (konsisten dengan transactions.doctor_id)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Hitung nilai insentif dalam rupiah berdasarkan harga tindakan.
     */
    public function calculatedValue(int $price): int
    {
        if ($this->type_incentive === 'percentage') {
            return (int) round($price * $this->incentive_value / 100);
        }

        return (int) $this->incentive_value;
    }
}
