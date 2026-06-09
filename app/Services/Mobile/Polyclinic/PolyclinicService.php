<?php

namespace App\Services\Mobile\Polyclinic;

use App\Models\Company\Company;
use App\Models\Location\Location;
use App\Traits\Company\CompanyTrait;

class PolyclinicService
{
    use CompanyTrait;
    /**
     * Create a new class instance.
     */
    public $company;

    public function __construct()
    {
        //
        $this->company = Company::where('code', config('app.company_code'))->first();
    }

    public function getPolyclinic()
    {
        $company_branches = $this->getCompanyBranches($this->company?->id, ['id'])->pluck('id')->toArray();

        $locations = Location::whereIn('company_id', $company_branches)->orderBy('order', 'asc')->where('status', 'active')->get();

        return $locations;
    }
}
