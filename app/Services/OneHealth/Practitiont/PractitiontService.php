<?php

namespace App\Services\OneHealth\Practitiont;

use App\Models\Company\Company;
use App\Traits\Company\CompanyTrait;
use App\Traits\OneHealth\AuthenticateTrait;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PractitiontService
{
    /**
     * Create a new class instance.
     */
    use AuthenticateTrait, CompanyTrait;

    public $url;

    public function __construct()
    {
        //
        $this->url = config('app.one_health.url').'/fhir-r4/v1';
    }

    // GET
    public function getPractitiont($request)
    {
        $company = Company::find($request?->company_id);

        $param = [
            'identifier' => 'https://fhir.kemkes.go.id/id/nik|'.$request?->nik,
        ];

        $queryString = http_build_query($param);
        $url = $this->url.'/Practitioner?'.$queryString;

        $response = Http::withToken($company?->one_health_access_token ?? '')
            ->withOptions(['verify' => false])
            ->timeout(60)
            ->get($url);

        if ($response->unauthorized()) {
            $this->accessToken($company);
            $company = Company::find($company?->id);

            $response = Http::withToken($company?->one_health_access_token ?? '')
                // ->withOptions(['verify' => false])
                ->get($this->url.'/Practitioner', $param);
        }

        $responseBody = $response->json();
        if (! $response->successful()) {
            $message = $responseBody['message'] ?? json_encode($responseBody);
            throw new Exception($message, 500);
        }

        if (config('app.name') != 'production') {
            Log::info('Successfully OneHealthPractitiontService->getPractitiont', $responseBody);
        }

        $response = [
            'success' => true,
            'message' => 'Successfully OneHealthPractitiontService->getPractitiont',
            'data' => $responseBody,
        ];

        return $response;
    }
}
