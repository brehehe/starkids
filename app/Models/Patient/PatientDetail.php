<?php

namespace App\Models\Patient;

use App\Models\Master\Region\City;
use App\Models\Master\Region\District;
use App\Models\Master\Region\Province;
use App\Models\Master\Region\SubDistrict;
use App\Traits\Region\RegionTrait;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PatientDetail extends Model
{
    //
    use HasUuids, RegionTrait, SoftDeletes;

    protected $guarded = ['id'];

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
            } catch (Exception|Throwable $th) {
                DB::rollBack();
                $error = [
                    'message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                ];

                Log::error('Ada kesalahan saat boot PatientDetail sync', $error);
            }
        });
    }

    /**
     * Get the patient that owns the PatientDetail
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function setProvince()
    {
        $province = Province::where('code', $this->province_code)->first();

        if (! $province) {
            $this->getProvinceTrait();
        }

        $province = Province::where('code', $this->province_code)->first();

        if ($province) {
            $this->updateQuietly([
                'province' => $province?->name,
            ]);
        }
    }

    public function setCity()
    {
        $city = City::where('code', $this->city_code)->where('parent_code', $this->province_code)->first();

        if (! $city) {
            $this->getCityTrait($this->province_code);
        }

        $city = City::where('code', $this->city_code)->where('parent_code', $this->province_code)->first();
        if ($city) {
            $this->updateQuietly([
                'city' => $city?->name,
            ]);
        }
    }

    public function setDistrict()
    {
        $district = District::where('code', $this->district_code)->where('parent_code', $this->city_code)->first();

        if (! $district) {
            $this->getDistrictTrait($this->city_code);
        }

        $district = District::where('code', $this->district_code)->where('parent_code', $this->city_code)->first();
        if ($district) {
            $this->updateQuietly([
                'district' => $district?->name,
            ]);
        }
    }

    public function setSubDistrict()
    {
        $subDistrict = SubDistrict::where('code', $this->sub_district_code)->where('parent_code', $this->district_code)->first();

        if (! $subDistrict) {
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
