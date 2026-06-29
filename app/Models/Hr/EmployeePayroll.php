<?php

namespace App\Models\Hr;

use App\Models\Company\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePayroll extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function components()
    {
        return $this->hasMany(EmployeePayrollComponent::class, 'employee_payroll_id');
    }

    protected function casts(): array
    {
        return [
            'basic_salary' => 'decimal:2',
        ];
    }
}
