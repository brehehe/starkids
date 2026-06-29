<?php

namespace App\Models\Hr;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Added this use statement
// Added this use statement

class EmployeePayrollComponent extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function employeePayroll()
    {
        return $this->belongsTo(EmployeePayroll::class, 'employee_payroll_id');
    }

    public function component()
    {
        return $this->belongsTo(PayrollComponent::class, 'payroll_component_id');
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }
}
