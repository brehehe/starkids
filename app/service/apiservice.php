<?php

namespace App\service;

use App\Models\User;
use App\Traits\Company\CompanyTrait;

class apiservice
{
    use CompanyTrait;

    protected $url;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        // $this->url = 'https://mediction.test/api';
        $this->url = config('app.url').'/api';
    }

    // -------------------------------------------------------------------------
    // SEMUA METHOD DI-STUB SEMENTARA → return null
    // Untuk restore, hapus file ini dan kembalikan dari git / backup.
    // -------------------------------------------------------------------------

    public function getPratition($request): mixed
    {
        return null;
    }

    public function createUser(User $user, bool $identity_card_mother = false): array
    {
        return [];
    }

    public function syncCompany($company): mixed
    {
        return null;
    }

    public function syncLocation($location): mixed
    {
        return null;
    }

    public function createTransaction($data): mixed
    {
        return null;
    }

    public function createConditionPrimary($data): mixed
    {
        return null;
    }

    public function createMedictation($data): mixed
    {
        return null;
    }

    public function createMedicationRequest($data): mixed
    {
        return null;
    }

    public function createMedicationDispense($data): mixed
    {
        return null;
    }

    public function createCompany($company): array
    {
        return [];
    }

    public function createCondition($data): mixed
    {
        return null;
    }
}
