<?php

namespace Database\Seeders\Company;

use App\Helpers\RoleHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Company\CompanyService;
use App\Models\Location\Location;
use App\Models\Poly\Poly;
use App\Models\Service\Service;
use App\Models\Service\ServiceMonth;
use App\Models\Spatie\Role;
use App\Models\User;
use App\Models\User\UserDetail;
use App\service\apiservice;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OptimizedCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Memulai optimized company seeding...');
        $startTime = microtime(true);

        // Optimize database for bulk operations
        $this->optimizeDatabaseForImport();

        DB::beginTransaction();

        try {
            // Batch create roles
            $this->createRolesBatch();

            // Get service month once
            $serviceMonth = ServiceMonth::where('name', 'Lifetime')->first();

            // Create companies with all related data
            $this->createCompaniesBatch($serviceMonth);

            DB::commit();

            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);

            $this->command->info('✅ Seeding selesai!');
            $this->command->info("⏱️  Waktu eksekusi: {$executionTime} detik");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Error: '.$e->getMessage());
            throw $e;
        } finally {
            // Restore database settings
            $this->restoreDatabaseSettings();
        }
    }

    /**
     * Create roles in batch
     */
    private function createRolesBatch(): void
    {
        $this->command->info('📋 Creating roles...');

        $roles = [
            ['uuid' => Str::uuid(), 'name' => 'Super Admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'name' => 'Dokter', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'name' => 'Perawat', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'name' => 'Terapis', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'name' => 'Apoteker', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'name' => 'Resepsionis', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'name' => 'Kasir', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['uuid' => Str::uuid(), 'name' => 'Pasien', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];

        // Check if roles already exist to avoid duplicates
        $existingRoles = Role::whereIn('name', array_column($roles, 'name'))->pluck('name')->toArray();
        $newRoles = array_filter($roles, function ($role) use ($existingRoles) {
            return ! in_array($role['name'], $existingRoles);
        });

        if (! empty($newRoles)) {
            DB::table('roles')->insert($newRoles);
        }
    }

    /**
     * Create companies with all related data in optimized batches
     */
    private function createCompaniesBatch($serviceMonth): void
    {
        $this->command->info('📋 Creating companies and related data...');

        $faker = Factory::create();
        $now = Carbon::now();

        $company_datas = [
            [
                'code' => 'Strkds',
                'name' => 'Starkids Medical Center',
                'email' => 'starkidsmedicalcenter@gmail.com',
                'phone' => '08'.$faker->numberBetween(100000000, 999999999),
                'website' => 'https://starkidsmedicalcenter.com',
                'service_id' => $serviceMonth->id,
                'address' => $faker->streetAddress(),
                'pic_name' => 'Starkids Medical Center',
                'pic_position' => 'CEO',
                'pic_email' => 'starkidsmedicalcenter@gmail.com',
                'pic_phone' => '08'.$faker->numberBetween(100000000, 999999999),
                'is_active' => true,
                'is_central' => true,
                'is_main' => true,
                'is_lifetime' => true,
                'branch' => 'Pusat',
                'logo' => 'logos/logo_'.Str::random(10).'.png',
            ],
        ];

        // Prepare logo file once
        $this->prepareLogo();

        foreach ($company_datas as $company_data) {
            // Create company
            $company = $this->createSingleCompany($company_data, $serviceMonth, $now);

            // Create all related data in batches
            $this->createCompanyRelatedData($company, $company_data, $serviceMonth, $now);

            // API calls at the end (can be async in production)
            $this->handleApiCalls($company, $company_data);
        }
    }

    /**
     * Create single company optimized
     */
    private function createSingleCompany($company_data, $serviceMonth, $now): Company
    {
        return Company::create([
            'id' => Str::uuid(),
            'code' => $company_data['code'],
            'name' => $company_data['name'],
            'email' => $company_data['email'],
            'phone' => $company_data['phone'],
            'website' => $company_data['website'],
            'pic_name' => $company_data['pic_name'],
            'pic_position' => $company_data['pic_position'],
            'pic_email' => $company_data['pic_email'],
            'pic_phone' => $company_data['pic_phone'],
            'is_active' => $company_data['is_active'],
            'is_central' => $company_data['is_central'],
            'is_main' => $company_data['is_main'],
            'is_lifetime' => $serviceMonth->is_lifetime,
            'expires_at' => $serviceMonth->is_lifetime ? null : now()->addDays($serviceMonth->duration_days),
            'service_id' => $company_data['service_id'],
            'start_date' => $now,
            'duration_days' => $serviceMonth->is_lifetime ? 0 : $serviceMonth->duration_days,
            'logo' => $company_data['logo'],
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * Create all company related data in batches
     */
    private function createCompanyRelatedData($company, $company_data, $serviceMonth, $now): void
    {
        // Batch create role companies
        $this->createRoleCompaniesBatch($company, $now);

        // Batch create payment methods
        $this->createPaymentMethodsBatch($company, $now);

        // Create user and user detail
        $this->createCompanyUserBatch($company, $now);

        // Create company detail
        $this->createCompanyDetailBatch($company, $now);

        // Create branch
        $this->createBranchBatch($company, $company_data['branch'], $now);

        // Create medicine types
        $this->createMedicineTypesBatch($company, $now);

        // Create company services
        $this->createCompanyServicesBatch($company, $serviceMonth, $now);

        // Create locations/poly
        $this->createLocationsBatch($company, $now);

        // Create OneHealth data
        $this->createOneHealthBatch($company, $now);
    }

    /**
     * Batch create role companies
     */
    private function createRoleCompaniesBatch($company, $now): void
    {
        $roles = Role::all();
        $roleCompanies = [];

        foreach ($roles as $role) {
            $roleCompanies[] = [
                'id' => Str::uuid(),
                'role_id' => $role->uuid,
                'company_id' => $company->id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($roleCompanies)) {
            DB::table('role_companies')->insert($roleCompanies);
        }
    }

    /**
     * Batch create payment methods
     */
    private function createPaymentMethodsBatch($company, $now): void
    {
        $paymentMethods = [
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Tunai',
                'is_offline_payment' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('payment_methods')->insert($paymentMethods);
    }

    /**
     * Create company user and user detail
     */
    private function createCompanyUserBatch($company, $now): void
    {
        $user = User::create([
            'id' => Str::uuid(),
            'name' => $company->pic_name,
            'email' => $company->email,
            'username' => strtolower(str_replace(' ', '', $company->pic_name)),
            'password' => bcrypt('12345678'),
            'email_verified_at' => $now,
            'company_id' => $company->id,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        UserDetail::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'address' => $company->address ?? '',
            'status' => 'active',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Assign role efficiently
        RoleHelper::assignRoleToUserInCompany($user, 'Super Admin', $company->id, null, true, true);
    }

    /**
     * Create company detail
     */
    private function createCompanyDetailBatch($company, $now): void
    {
        $companyDetail = [
            'id' => Str::uuid(),
            'company_id' => $company->id,
            'one_health_code' => '1004946874',
            'facility_code' => '35780100662',
            'organization_id' => '100494687',
            'longitude' => '112.6929322',
            'latitude' => '-7.2717084',
            'province_code' => 35,
            'city_code' => 3515,
            'district_code' => 351508,
            'sub_district_code' => 3515081005,
            'postal_code' => 60115,
            'address' => 'Jl. Dharmahusada Indah I No.17',
            'rt' => 001,
            'rw' => 002,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('company_details')->insert($companyDetail);
    }

    /**
     * Create branch
     */
    private function createBranchBatch($company, $branchName, $now): void
    {
        $branch = [
            'id' => Str::uuid(),
            'company_id' => $company->id,
            'name' => $branchName,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('branches')->insert($branch);
    }

    /**
     * Create medicine types
     */
    private function createMedicineTypesBatch($company, $now): void
    {
        $medicineTypes = [
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Paten',
                'service_price' => 1000,
                'is_single' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Puyer',
                'service_price' => 1000,
                'is_single' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Capsule',
                'service_price' => 500,
                'is_single' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Syrup',
                'service_price' => 2000,
                'is_single' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Cream',
                'service_price' => 1500,
                'is_single' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Mix',
                'service_price' => 1000,
                'is_single' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('medicine_types')->insert($medicineTypes);
    }

    /**
     * Create company services
     */
    private function createCompanyServicesBatch($company, $serviceMonth, $now): void
    {
        $companyService = CompanyService::create([
            'id' => Str::uuid(),
            'company_id' => $company->id,
            'service_month_id' => $serviceMonth->id,
            'start_date' => $now,
            'duration_days' => $serviceMonth->is_lifetime ? 0 : $serviceMonth->duration_days,
            'expires_at' => $serviceMonth->is_lifetime ? null : now()->addDays($serviceMonth->duration_days),
            'is_lifetime' => $serviceMonth->is_lifetime,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Create company service months
        $serviceMonthDetails = ServiceMonth::where('id', $serviceMonth->id)
            ->with('serviceMonthDetails')
            ->first()
            ->serviceMonthDetails;

        $companyServiceMonths = [];
        foreach ($serviceMonthDetails as $detail) {
            $companyServiceMonths[] = [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'company_service_id' => $companyService->id,
                'service_month_id' => $detail->id,
                'start_date' => $now,
                'duration_days' => $serviceMonth->is_lifetime ? 0 : $serviceMonth->duration_days,
                'expires_at' => $serviceMonth->is_lifetime ? null : now()->addDays($serviceMonth->duration_days),
                'is_lifetime' => $serviceMonth->is_lifetime,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($companyServiceMonths)) {
            DB::table('company_service_months')->insert($companyServiceMonths);
        }
    }

    /**
     * Create locations/poly
     */
    private function createLocationsBatch($company, $now): void
    {
        $locations = [
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Poli Umum',
                'slug' => Str::slug('Poli Umum'),
                'description' => 'Pelayanan umum untuk semua pasien',
                'mode' => 'instance',
                'physical_type' => 'si',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'company_id' => $company->id,
                'name' => 'Instalasi Farmasi',
                'slug' => Str::slug('Instalasi Farmasi'),
                'description' => 'Pelayanan farmasi untuk semua pasien',
                'mode' => 'instance',
                'physical_type' => 'si',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('locations')->insert($locations);
    }

    /**
     * Create OneHealth data
     */
    private function createOneHealthBatch($company, $now): void
    {
        $oneHealthData = [
            'id' => Str::uuid(),
            'company_id' => $company->id,
            'organization_id' => Crypt::encryptString(config('app.one_health.organization_id')),
            'client_id' => Crypt::encryptString(config('app.one_health.client_id')),
            'client_secret' => Crypt::encryptString(config('app.one_health.client_secret')),
            'created_at' => $now,
            'updated_at' => $now,
        ];

        DB::table('one_healthies')->insert($oneHealthData);
    }

    /**
     * Prepare logo file
     */
    private function prepareLogo(): void
    {
        $sourcePath = public_path('asset/img/logo-starkids.png');

        if (file_exists($sourcePath)) {
            $filename = 'logo_'.Str::random(10).'.png';
            $destinationPath = 'logos/'.$filename;
            Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
        }
    }

    /**
     * Handle API calls (can be made async in production)
     */
    private function handleApiCalls($company, $company_data): void
    {
        try {
            // These can be made async or queued in production for better performance
            app(apiservice::class)->syncCompany($company);

            // Sync locations
            $locations = Location::where('company_id', $company->id)->get();
            foreach ($locations as $location) {
                app(apiservice::class)->syncLocation($location);
            }
        } catch (\Exception $e) {
            // Log error but don't fail the seeding
            $this->command->warn('⚠️ API sync failed: '.$e->getMessage());
        }
    }

    /**
     * Optimize database for bulk operations
     */
    private function optimizeDatabaseForImport(): void
    {
        $driver = DB::getDriverName();

        try {
            switch ($driver) {
                case 'mysql':
                    DB::statement('SET autocommit=0');
                    DB::statement('SET unique_checks=0');
                    DB::statement('SET foreign_key_checks=0');
                    DB::statement('SET sql_log_bin=0');
                    break;

                case 'pgsql':
                    DB::statement('SET synchronous_commit TO OFF');
                    DB::statement('SET maintenance_work_mem TO "256MB"');
                    DB::statement('SET log_statement TO "none"');
                    break;

                case 'sqlite':
                    DB::statement('PRAGMA synchronous = OFF');
                    DB::statement('PRAGMA journal_mode = MEMORY');
                    break;
            }
        } catch (\Exception $e) {
            // Silent fallback
        }
    }

    /**
     * Restore database settings
     */
    private function restoreDatabaseSettings(): void
    {
        $driver = DB::getDriverName();

        try {
            switch ($driver) {
                case 'mysql':
                    DB::statement('SET foreign_key_checks=1');
                    DB::statement('SET unique_checks=1');
                    DB::statement('SET autocommit=1');
                    DB::statement('SET sql_log_bin=1');
                    break;

                case 'pgsql':
                    DB::statement('SET synchronous_commit TO ON');
                    DB::statement('RESET maintenance_work_mem');
                    DB::statement('RESET log_statement');
                    break;

                case 'sqlite':
                    DB::statement('PRAGMA synchronous = NORMAL');
                    DB::statement('PRAGMA journal_mode = DELETE');
                    break;
            }
        } catch (\Exception $e) {
            // Silent restore
        }
    }
}
