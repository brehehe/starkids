<?php

namespace App\Models\Hr;

// Fixed import for the new relationship
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    use HasUuids;

    protected $guarded = ['id'];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class, 'payroll_id');
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }
}
