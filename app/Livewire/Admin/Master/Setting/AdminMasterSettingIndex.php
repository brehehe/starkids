<?php

namespace App\Livewire\Admin\Master\Setting;

use App\Helpers\AlertHelper;
use App\Http\Controllers\API\OneHealth\Auth\AuthController;
use App\Models\Company\Company;
use App\Models\Company\CompanyDetail;
use App\Models\Company\CompanyService;
use App\Models\Company\OneHealthy;
use App\Models\Country\Country;
use App\service\apiservice;
use App\Traits\Region\RegionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AdminMasterSettingIndex extends Component
{
    use RegionTrait, WithFileUploads;

    public $tabs = [
        'perusahaan',
        // 'satu-sehat',
        'layanan',
    ];

    public $currentTab;

    // General
    public $company_id;

    public $company_main_id;

    public $getProvinces = [];

    public $getCities = [];

    public $getDistricts = [];

    public $getSubDistricts = [];

    public $url;

    public $getCountrys = [];

    public $code_health_facility;

    // Perusahaan
    public $code;

    public $name;

    public $email_company;

    public $phone;

    public $website;

    public $province;

    public $city;

    public $district;

    public $sub_district;

    public $postal_code;

    public $country;

    public $address;

    public $logo_old;

    public $logo;

    public $icon_old;

    public $icon;

    public $tax_id;

    public $industry;

    public $description;

    public $pic_name;

    public $pic_position;

    public $pic_phone;

    public $pic_email;

    public $is_editable_price_pos = false;

    // Satu Sehat
    public $organization_id;

    public $client_id;

    public $client_secret;

    // Attendance Settings
    public $work_days = [];

    public $clock_in_time;

    public $clock_out_time;

    public $latitude;

    public $longitude;

    public $attendance_radius;

    // Service
    public $companyServices = [];

    public $with_pharmacy = false;

    public function mount()
    {
        $this->company_id = Auth::user()->company_id;

        $access_token = Cache::get('accessToken');

        if (! $access_token) {
            (new AuthController)->accessToken();
            $access_token = Cache::get('accessToken');
        }
        $this->url = Env('APP_URL');

        $this->getProvinces = $this->getProvinceTrait();

        $this->getCountrys = Country::select('code', 'name')->orderBy('name', 'asc')->get()->toArray();
        $this->setTab('perusahaan');
    }

    public function setTab($tab)
    {
        $this->reset(['organization_id', 'client_id', 'client_secret', 'code', 'name', 'email_company', 'phone', 'website', 'province', 'city', 'district', 'sub_district', 'postal_code', 'address', 'logo_old', 'logo', 'tax_id', 'industry', 'description', 'pic_name', 'pic_position', 'pic_phone', 'pic_email', 'companyServices', 'work_days', 'clock_in_time', 'clock_out_time', 'latitude', 'longitude', 'attendance_radius']);

        if ($tab === 'perusahaan') {
            $company = Company::select([
                'id',
                'code',
                'name',
                'email',
                'phone',
                'website',
                'logo',
                'icon',
                'tax_id',
                'industry',
                'description',
                'pic_name',
                'pic_position',
                'pic_phone',
                'pic_email',
                'code_health_facility',
                'is_editable_price_pos',
                'with_pharmacy',
                'work_days',
                'clock_in_time',
                'clock_out_time',
                'latitude',
                'longitude',
                'attendance_radius',
            ])->with('companyDetail')->find($this->company_id);

            if ($company) {
                $this->company_main_id = $company->company_id;
                $this->code = $company->code;
                $this->name = $company->name;
                $this->email_company = $company->email;
                $this->phone = $company->phone;
                $this->website = $company->website;
                $this->icon_old = $company->icon;
                $this->code_health_facility = $company->code_health_facility;
                $this->is_editable_price_pos = (bool) $company->is_editable_price_pos;
                $this->with_pharmacy = (bool) $company->with_pharmacy;
                $this->work_days = $company->work_days ? json_decode($company->work_days, true) : [];
                $this->clock_in_time = $company->clock_in_time;
                $this->clock_out_time = $company->clock_out_time;
                $this->latitude = $company->latitude;
                $this->longitude = $company->longitude;
                $this->attendance_radius = $company->attendance_radius;
                if ($company->companyDetail->province_code) {
                    $this->province = $company->companyDetail->province_code;
                    $this->updatedProvince(); // Trigger the updatedProvince even
                }
                if ($company->companyDetail->city_code) {
                    $this->city = $company->companyDetail->city_code;
                    $this->updatedCity(); // Trigger the updatedProvince even
                }
                if ($company->companyDetail->district_code) {
                    $this->district = $company->companyDetail->district_code;
                    $this->updatedDistrict(); // Trigger the updatedProvince even
                }

                if ($company->companyDetail->sub_district_code) {
                    $this->sub_district = $company->companyDetail->sub_district_code;
                }

                $this->postal_code = $company->companyDetail->postal_code;
                $this->country = $company->companyDetail->country;
                $this->address = $company->companyDetail->address;
                $this->logo_old = $company->logo;
                $this->tax_id = $company->tax_id;
                $this->industry = $company->industry;
                $this->description = $company->description;
                $this->pic_name = $company->pic_name;
                $this->pic_position = $company->pic_position;
                $this->pic_phone = $company->pic_phone;
                $this->pic_email = $company->pic_email;
            }

            $oneHealth = OneHealthy::where('company_id', $this->company_id)->first();
            if ($oneHealth) {
                $this->organization_id = Crypt::decryptString($oneHealth->organization_id);
                $this->client_id = Crypt::decryptString($oneHealth->client_id);
                $this->client_secret = Crypt::decryptString($oneHealth->client_secret);
            }
        } elseif ($tab === 'layanan') {
            $this->companyServices = CompanyService::select('id', 'start_date', 'company_id', 'service_month_id', 'duration_days', 'is_lifetime')->with('serviceMonth:id,name,description', 'company:id,name,description')->where('company_id', $this->company_id)->get();
        }
        $this->currentTab = $tab;
    }

    public function updatedProvince()
    {
        $this->reset(['getCities', 'city', 'district', 'sub_district']);

        if ($this->province) {
            $this->getCities = $this->getCityTrait($this->province);
        }
    }

    public function updatedCity()
    {
        $this->reset(['getDistricts', 'district', 'sub_district']);

        if ($this->city) {
            $this->getDistricts = $this->getDistrictTrait($this->city);
        }
    }

    public function updatedDistrict()
    {
        $this->reset(['getSubDistricts', 'sub_district']);

        if ($this->district) {
            $this->getSubDistricts = $this->getSubDistrictTrait($this->district);
        }
    }

    public function save()
    {
        if ($this->currentTab === 'perusahaan') {
            $this->validate([
                'code' => $this->company_id ? 'nullable' : 'required|min:3|max:6|unique:companies,code',
                'name' => 'required',
                'email_company' => 'required',
                'phone' => 'required',
                'province' => 'required',
                'city' => 'required',
                'district' => 'required',
                'sub_district' => 'required',
                'postal_code' => 'required',
                'country' => 'required',
                'address' => 'required',
                'pic_name' => 'required',
                'pic_position' => 'required',
                'pic_phone' => 'required',
                'pic_email' => 'required',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'organization_id' => 'required',
                'client_id' => 'required',
                'client_secret' => 'required',
                'code_health_facility' => 'required',
                'is_editable_price_pos' => 'boolean',
                'with_pharmacy' => 'boolean',
                'work_days' => 'nullable|array',
                'clock_in_time' => 'nullable',
                'clock_out_time' => 'nullable',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'attendance_radius' => 'nullable|numeric',
            ]);

            try {
                DB::beginTransaction();

                if ($this->logo) {
                    $manager = new ImageManager(new Driver);
                    $image = $manager->read($this->logo->getRealPath());
                    if ($image->width() > 1024) {
                        $image->scaleDown(width: 1024);
                    }
                    $encoded = $image->toWebp(75);
                    $randomName = Str::random(40).'.webp';

                    Storage::disk('public')->put('company/'.$randomName, (string) $encoded);
                    $this->logo = 'company/'.$randomName; // untuk simpan di database
                } else {
                    $this->logo = $this->logo_old; // fallback jika tidak ada upload baru
                }

                if ($this->icon) {
                    $manager = new ImageManager(new Driver);
                    $image = $manager->read($this->icon->getRealPath());
                    if ($image->width() > 512) {
                        $image->scaleDown(width: 512); // Ikon cukup ukuran kecil
                    }
                    $encoded = $image->toWebp(75);
                    $randomName = Str::random(40).'.webp';

                    Storage::disk('public')->put('company/'.$randomName, (string) $encoded);
                    $this->icon = 'company/'.$randomName; // untuk simpan di database
                } else {
                    $this->icon = $this->icon_old; // fallback jika tidak ada upload baru
                }

                $getCompany = Company::where('id', $this->company_id)->first();

                $company = Company::updateOrCreate([
                    'id' => $this->company_id,
                ], [
                    'company_id' => $this->company_main_id ? $this->company_main_id : Auth::user()->company_id,
                    'code' => $this->code,
                    'name' => $this->name,
                    'email' => $this->email_company,
                    'phone' => $this->phone,
                    'website' => $this->website,
                    'logo' => $this->logo,
                    'icon' => $this->icon,
                    'tax_id' => $this->tax_id,
                    'code_health_facility' => $this->code_health_facility,
                    'industry' => $this->industry,
                    'description' => $this->description,
                    'country' => $this->country,
                    'pic_name' => $this->pic_name,
                    'pic_position' => $this->pic_position,
                    'pic_phone' => $this->pic_phone,
                    'pic_email' => $this->pic_email,
                    'is_editable_price_pos' => $this->is_editable_price_pos == true ? true : false,
                    'with_pharmacy' => $this->with_pharmacy == true ? true : false,
                    'work_days' => json_encode($this->work_days),
                    'clock_in_time' => $this->clock_in_time,
                    'clock_out_time' => $this->clock_out_time,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'attendance_radius' => $this->attendance_radius,
                ]);

                CompanyDetail::updateOrCreate([
                    'company_id' => $company->id,
                ], [
                    'province_code' => $this->province,
                    'city_code' => $this->city,
                    'district_code' => $this->district,
                    'sub_district_code' => $this->sub_district,
                    'postal_code' => $this->postal_code,
                    'address' => $this->address,
                    'country' => $this->country,
                ]);

                OneHealthy::updateOrCreate([
                    'company_id' => $company->id,
                ], [
                    'organization_id' => Crypt::encryptString($this->organization_id),
                    'client_id' => Crypt::encryptString($this->client_id),
                    'client_secret' => Crypt::encryptString($this->client_secret),
                ]);

                DB::commit();

                app(apiservice::class)->syncCompany($company);

                $this->reset(['logo', 'icon']);

                $this->logo_old = $company->logo;
                $this->icon_old = $company->icon;

                return AlertHelper::success('Berhasil', 'Data perusahaan berhasil disimpan.');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Error saving company details: '.$e->getMessage());

                return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menyimpan data: '.$e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.master.setting.admin-master-setting-index')
            ->extends('layout.app')
            ->section('content');
    }
}
