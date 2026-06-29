<?php

namespace App\Models\Family;

use App\Models\Company\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    public function headUser()
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    public function members()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
