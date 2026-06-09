<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\RoleHelper;
use App\Models\Company\Company;
use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use App\Models\User\ControlDoctor;
use App\Models\User\UserCompanyRole;
use App\Models\User\UserDetail;
use App\Models\User\UserPrice;
use App\Models\User\UserType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, HasUuids, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id', 'id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_user_role')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function rolesInCompany($companyId)
    {
        return DB::table('company_user_role')
            ->where('user_id', $this->id)
            ->where('company_id', $companyId)
            ->pluck('role_id');
    }

    public function hasCompanyRole($roles, $companyId): bool
    {
        // Biar fleksibel, bisa string atau array
        $roles = is_array($roles) ? $roles : [$roles];
        foreach ($roles as $role) {
            if (RoleHelper::hasCompanyRole($this, $role, $companyId)) {
                return true;
            }
        }

        return false;
    }

    public function scopeCompanyChoice($query, $companyId, $is_head = false)
    {
        return $query->whereHas('companyRoles', function ($q) use ($companyId, $is_head) {
            $q->where('company_id', $companyId);
            if ($is_head) {
                $q->where('is_head', true);
            }
        });
    }

    public function scopeCompanyRole($query, $roleName, $companyId)
    {
        return $query->whereHas('companyRoles', function ($q) use ($roleName, $companyId) {
            $q->whereHas('role', function ($qr) use ($roleName) {
                $qr->where('name', $roleName);
            })->where('company_id', $companyId);
        });
    }

    public function scopeCompanyWithoutRolePasienAndDokter($query, $companyIds)
    {
        return $query->whereHas('companyRoles', function ($q) use ($companyIds) {
            // Hanya filter company_id dulu
            $q->whereIn('company_id', (array) $companyIds);
        });
    }

    public function companyRoles()
    {
        return $this->hasMany(UserCompanyRole::class);
    }

    public function userDetail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    protected static function booted()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
            // $modelCreate->user_type_id = $modelCreate->wuser_type_id ?? UserType::where('name', 'Umum')->first()->id; // Default to 'member' if not set
        });

        static::updating(function ($modelUpdate) {
            $modelUpdate->phone = trim($modelUpdate->phone);
        });
    }

    public function hasRoleInCompany($companyId, $roleId = null)
    {
        $query = $this->companyRoles()
            ->where('company_id', $companyId)
            ->where('is_active', true);

        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        return $query->exists();
    }

    public function addAlternativeContact($type, $value, $context = null, $reason = null)
    {
        $contacts = $this->alternative_contacts ?? [];

        $contacts[] = [
            'type' => $type, // email, phone
            'value' => $value,
            'context' => $context, // company_id
            'reason' => $reason, // conflict_resolution, user_preference, etc
            'added_at' => now()->toISOString(),
        ];

        $this->update(['alternative_contacts' => $contacts]);

        return $this;
    }

    public function getContactForContext($type, $context = null)
    {
        $contacts = $this->alternative_contacts ?? [];

        foreach ($contacts as $contact) {
            if ($contact['type'] === $type && $contact['context'] === $context) {
                return $contact['value'];
            }
        }

        // Fallback to main contact
        return $type === 'email' ? $this->email : $this->phone;
    }

    public function getAllEmails()
    {
        $emails = [$this->email];
        $contacts = $this->alternative_contacts ?? [];

        foreach ($contacts as $contact) {
            if ($contact['type'] === 'email') {
                $emails[] = $contact['value'];
            }
        }

        return array_unique(array_filter($emails));
    }

    public function getAllPhones()
    {
        $phones = [$this->phone];
        $contacts = $this->alternative_contacts ?? [];

        foreach ($contacts as $contact) {
            if ($contact['type'] === 'phone') {
                $phones[] = $contact['value'];
            }
        }

        return array_unique(array_filter($phones));
    }

    // Static Methods
    public static function findByEmailOrPhone($emailOrPhone)
    {
        // Check main email/phone first
        $user = static::where('email', $emailOrPhone)
            ->orWhere('phone', $emailOrPhone)
            ->orWhere('username', $emailOrPhone)
            ->first();

        if ($user) {
            return $user;
        }

        // Check alternative contacts
        return static::whereJsonContains('alternative_contacts', function ($contact) use ($emailOrPhone) {
            return ($contact['type'] === 'email' && $contact['value'] === $emailOrPhone) ||
                ($contact['type'] === 'phone' && $contact['value'] === $emailOrPhone);
        })->first();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeSearch($query, $search)
    {
        // Coba parsing input sebagai tanggal
        $parsedDate = null;
        $parsedMonth = null;
        $parsedYear = null;

        try {
            // Carbon otomatis bisa parse "08 Maret 2002", "Maret 2002", "2002"
            $parsed = Carbon::parse($search, 'id');
            $parsedDate = $parsed->format('Y-m-d');
            $parsedMonth = $parsed->month;
            $parsedYear = $parsed->year;
        } catch (\Exception $e) {
            // kalau bukan format tanggal → biarin null
        }

        return $query->where(function ($q) use ($search, $parsedDate, $parsedMonth, $parsedYear) {
            $q->where('name', 'ilike', "%{$search}%")
                ->orWhere('email', 'ilike', "%{$search}%")
                ->orWhere('phone', 'ilike', "%{$search}%")
                ->orWhere('username', 'ilike', "%{$search}%")
                ->orWhereHas('companyRoles', function ($r) use ($search) {
                    $r->where('medical_record_number', 'ilike', "%{$search}%")
                      ->orWhereHas('role', function ($qr) use ($search) {
                          $qr->where('name', 'ilike', "%{$search}%");
                      });
                })
                ->orWhereHas('userDetail', function ($qd) use ($search, $parsedDate, $parsedMonth, $parsedYear) {
                    $qd->where('identity_card', 'ilike', "%{$search}%")
                        ->orWhere('address', 'ilike', "%{$search}%")
                        ->orWhere('ihs_number', 'ilike', "%{$search}%");

                    // 🔹 Jika input valid tanggal lengkap
                    if ($parsedDate) {
                        $qd->orWhereDate('birth_date', $parsedDate);
                    }

                    // 🔹 Jika hanya ada tahun
                    if ($parsedYear && ! $parsedDate) {
                        $qd->orWhereYear('birth_date', $parsedYear);
                    }

                    // 🔹 Jika ada bulan + tahun
                    if ($parsedYear && $parsedMonth && ! $parsedDate) {
                        $qd->orWhere(function ($q2) use ($parsedYear, $parsedMonth) {
                            $q2->whereYear('birth_date', $parsedYear)
                                ->whereMonth('birth_date', $parsedMonth);
                        });
                    }

                    // 🔹 Fallback: coba cocokkan dengan format string tanggal di DB (butuh lc_time=id_ID biar bulan Indo)
                    $qd->orWhereRaw("to_char(birth_date, 'DD FMMonth YYYY') ILIKE ?", ["%{$search}%"])
                        ->orWhereRaw("to_char(birth_date, 'FMMonth YYYY') ILIKE ?", ["%{$search}%"])
                        ->orWhereRaw("to_char(birth_date, 'YYYY') ILIKE ?", ["%{$search}%"]);
                });
        });
    }

    public function userPrice()
    {
        return $this->hasOne(UserPrice::class, 'user_id', 'id');
    }

    public function controlDoctors()
    {
        return $this->hasMany(ControlDoctor::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userControlSchedules()
    {
        return $this->hasMany(\App\Models\User\UserControlSchedule::class, 'user_id');
    }

    public function familyMembers()
    {
        return $this->hasMany(\App\Models\Family\FamilyMember::class, 'user_id');
    }

    public function family()
    {
        return $this->hasOneThrough(
            \App\Models\Family\Family::class,
            \App\Models\Family\FamilyMember::class,
            'user_id', // Foreign key on family_members table...
            'id', // Foreign key on families table...
            'id', // Local key on users table...
            'family_id' // Local key on family_members table...
        );
    }

    public function roleDoctor()
    {
        return $this->hasOne(Doctor::class, 'user_id', 'id');
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class, 'user_id');
    }

    public function leaves()
    {
        return $this->hasMany(\App\Models\Leave::class, 'user_id');
    }

    public function employeePayroll()
    {
        return $this->hasOne(\App\Models\Hr\EmployeePayroll::class, 'user_id');
    }

    public function shift()
    {
        return $this->belongsTo(\App\Models\Hr\Shift::class, 'shift_id');
    }

    /**
     * Incentives earned by this user for referring other patients.
     */
    public function patientReferralIncentivesGiven()
    {
        return $this->hasMany(\App\Models\Patient\PatientReferralIncentive::class, 'referrer_id');
    }

    /**
     * Incentive generated when this user was referred by someone.
     */
    public function patientReferralIncentiveReceived()
    {
        return $this->hasOne(\App\Models\Patient\PatientReferralIncentive::class, 'referred_id');
    }
}
