<?php

namespace App\Models\User;

use App\Models\Company\Company;
use App\Models\Master\Region\City;
use App\Models\Master\Region\District;
use App\Models\Master\Region\Province;
use App\Models\Master\Region\SubDistrict;
use App\Traits\Region\RegionTrait;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserDetail extends Model
{
    //
    use SoftDeletes, HasUuids, RegionTrait;
    protected $guarded = ['id'];

    protected $casts = [
        'birth_date' => 'date'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * Accessor untuk identity_card - otomatis decrypt
     */
    public function getIdentityCardAttribute($value)
    {
        if (empty($value)) {
            return $value;
        }

        try {
            // Coba decrypt value
            $decrypted = Crypt::decryptString($value);
            return $decrypted;
        } catch (\Exception $e) {
            // Jika gagal decrypt, kemungkinan data belum dienkripsi, return as is
            return $value;
        }
    }

    /**
     * Accessor untuk menampilkan identity_card yang sudah di-mask
     */
    public function getIdentityCardDisplayAttribute()
    {
        $identityCard = $this->identity_card; // Akan otomatis decrypt lewat accessor di atas

        if (empty($identityCard)) {
            return '-';
        }

        // Mask NIK: tampilkan 4 digit pertama dan 4 digit terakhir
        if (strlen($identityCard) >= 8) {
            return substr($identityCard, 0, 4) . str_repeat('*', strlen($identityCard) - 8) . substr($identityCard, -4);
        }

        return str_repeat('*', strlen($identityCard));
    }

    /**
     * Mutator untuk identity_card - otomatis encrypt saat disimpan
     */
    public function setIdentityCardAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['identity_card'] = $value;
            return;
        }

        // Cek apakah sudah terenkripsi
        try {
            Crypt::decryptString($value);
            // Jika berhasil decrypt, berarti sudah terenkripsi
            $this->attributes['identity_card'] = $value;
        } catch (\Exception $e) {
            // Jika gagal decrypt, berarti belum terenkripsi, encrypt sekarang
            $this->attributes['identity_card'] = Crypt::encryptString($value);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelCreate) {
            $lastOrder = static::max('order');
            $modelCreate->order = $lastOrder ? $lastOrder + 1 : 1;
        });

        static::saved(function ($model) {
            try {
                // Force commit any pending transactions before proceeding
                $initialTransactionLevel = DB::transactionLevel();
                if ($initialTransactionLevel > 0) {

                    while (DB::transactionLevel() > 0) {
                        DB::commit();
                    }
                }

                $model->setProvince();
                $model->setCity();
                $model->setDistrict();
                $model->setSubDistrict();
            } catch (Exception | Throwable $th) {
                DB::rollBack();
                $error = [
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                ];

                Log::error('Ada kesalahan saat boot CompanyDetail sync', $error);
            }
        });
    }

    function setProvince()
    {
        $province = Province::where('code', $this->province_code)->first();

        if (!$province) {
            $this->getProvinceTrait();
        }

        $province = Province::where('code', $this->province_code)->first();
        if ($province) {
            $this->updateQuietly([
                'province' => $province?->name,
            ]);
        }
    }

    function setCity()
    {
        $city = City::where('code', $this->city_code)->where('parent_code', $this->province_code)->first();

        if (!$city) {
            $this->getCityTrait($this->province_code);
        }

        $city = City::where('code', $this->city_code)->where('parent_code', $this->province_code)->first();
        if ($city) {
            $this->updateQuietly([
                'city' => $city?->name,
            ]);
        }
    }

    function setDistrict()
    {
        $district = District::where('code', $this->district_code)->where('parent_code', $this->city_code)->first();

        if (!$district) {
            $this->getDistrictTrait($this->city_code);
        }

        $district = District::where('code', $this->district_code)->where('parent_code', $this->city_code)->first();
        if ($district) {
            $this->updateQuietly([
                'district' => $district?->name,
            ]);
        }
    }

    function setSubDistrict()
    {
        $subDistrict = SubDistrict::where('code', $this->sub_district_code)->where('parent_code', $this->district_code)->first();

        if (!$subDistrict) {
            $this->getSubDistrictTrait($this->district_code);
        }

        $subDistrict = SubDistrict::where('code', $this->sub_district_code)->where('parent_code', $this->district_code)->first();
        if ($subDistrict) {
            $this->updateQuietly([
                'sub_district' => $subDistrict?->name,
            ]);
        }
    }
}
