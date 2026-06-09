<?php

namespace App\Livewire\Admin\Master\Company\Detail;

use App\Helpers\AlertHelper;
use App\Http\Controllers\API\OneHealth\Auth\AuthController;
use App\Models\Branch\Branch;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Company\Company;
use App\Models\Company\CompanyDetail;
use App\Models\Company\OneHealthy;
use App\Models\Country\Country;
use App\service\apiservice;
use App\Traits\Region\RegionTrait;
use Cache;
use Session;
use Crypt;
use Auth;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AdminMasterCompanyDetailIndex extends Component
{
    use WithFileUploads, RegionTrait;
    // General
    public $company_id;
    public $company_main_id;

    public $getProvinces = [];

    public $getCities = [];

    public $getDistricts = [];

    public $getSubDistricts = [];

    public $url;

    public $getCountrys = [];

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

    public $tax_id;

    public $industry;

    public $description;

    public $pic_name;

    public $pic_position;

    public $pic_phone;

    public $pic_email;

    // Satu Sehat
    public $organization_id;

    public $client_id;

    public $client_secret;

    // Service
    public $companyServices = [];

    public function mount()
    {
        $company = Company::find(Session::get('company_id'));

        if ($company) {
            $this->company_id = $company->id;
            $this->company_main_id = $company->company_id;
            $this->code = $company->code;
            $this->name = $company->name;
            $this->email_company = $company->email;
            $this->phone = $company->phone;
            $this->website = $company->website;
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
        } else {
            $this->company_main_id = null;

            $oneHealth = OneHealthy::where('company_id', Auth::user()->company_id)->first();
            if ($oneHealth) {
                $this->organization_id = Crypt::decryptString($oneHealth->organization_id);
                $this->client_id = Crypt::decryptString($oneHealth->client_id);
                $this->client_secret = Crypt::decryptString($oneHealth->client_secret);
            }
        }

        $oneHealth = OneHealthy::where('company_id', $this->company_id)->first();
        if ($oneHealth) {
            $this->organization_id = Crypt::decryptString($oneHealth->organization_id);
            $this->client_id = Crypt::decryptString($oneHealth->client_id);
            $this->client_secret = Crypt::decryptString($oneHealth->client_secret);
        }

        $this->url = Env('APP_URL');

        $this->getProvinces = $this->getProvinceTrait();

        $this->getCountrys = Country::select('code', 'name')->orderBy('name', 'asc')->get()->toArray();
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
            'organization_id' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($this->logo) {
                $randomName = Str::random(40) . '.' . $this->logo->getClientOriginalExtension();
                $logoPath = $this->logo->storeAs('public/company', $randomName);
                $this->logo = $logoPath; // untuk simpan di database
            } else {
                $this->logo = $this->logo_old; // fallback jika tidak ada upload baru
            }

            $company = Company::updateOrCreate([
                'id' => $this->company_id,
                'company_id' => $this->company_main_id ? $this->company_main_id : Auth::user()->company_id,
            ], [
                'code' => $this->code,
                'name' => $this->name,
                'email' => $this->email_company,
                'phone' => $this->phone,
                'website' => $this->website,
                'logo' => $this->logo,
                'tax_id' => $this->tax_id,
                'industry' => $this->industry,
                'description' => $this->description,
                'country' => $this->country,
                'pic_name' => $this->pic_name,
                'pic_position' => $this->pic_position,
                'pic_phone' => $this->pic_phone,
                'pic_email' => $this->pic_email,
                'is_main' => false,
                'start_date' => now(),
                'service_id' => Auth::user()->company->service_id,
                'is_lifetime' => Auth::user()->company->is_lifetime,
                'is_active' => Auth::user()->company->is_active,
            ]);

            Branch::updateOrCreate([
                'company_id' => $company->id,
            ], [
                'name'       => 'Pusat',
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

            $this->reset(['logo']);

            $this->logo_old = $company->logo;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saving company details: ' . $e->getMessage());
            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        session()->flash('saved', [
            'title' => 'Berhasil!',
            'text' => 'Data berhasil disimpan!',
        ]);

        return redirect()->intended(route('user.master.company'));
    }

    public function render()
    {
        return view('livewire.admin.master.company.detail.admin-master-company-detail-index')
            ->extends('layout.app')
            ->section('content');
    }
}
