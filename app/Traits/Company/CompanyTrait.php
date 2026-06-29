<?php

namespace App\Traits\Company;

use App\Models\Company\Company;
use Illuminate\Support\Facades\Crypt;

trait CompanyTrait
{
    //
    public function getOneHealth($company)
    {
        $one_healthy = $organization_id = $client_id = $client_secret = null;

        if (! $company) {
            return [$organization_id, $client_id, $client_secret];
        }

        $one_healthy = $this->getCompanyHasOneHealth($company)?->oneHealthy;

        if (! $one_healthy) {
            return [$organization_id, $client_id, $client_secret];
        }

        $organization_id = Crypt::decryptString($one_healthy?->organization_id);
        $client_id = Crypt::decryptString($one_healthy?->client_id);
        $client_secret = Crypt::decryptString($one_healthy?->client_secret);

        return [$organization_id, $client_id, $client_secret];
    }

    public function getCompanyHasOneHealth($company)
    {
        do {
            if ($company?->oneHealthy) {
                break;
            }

            $company = $company?->company;

        } while ($company != null);

        return $company;
    }

    public function getCompanyBranches($company_id, $select = [])
    {
        return Company::where('id', $company_id)->orWhere('company_id', $company_id)->when(! empty($select), function ($query) use ($select) {
            $query->select($select);
        })->orderBy('order', 'ASC')->get();
    }
}
