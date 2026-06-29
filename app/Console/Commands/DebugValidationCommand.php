<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class DebugValidationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:validation {phone} {--name=} {--nik=} {--mother=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug validation logic for phone number';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phone = $this->argument('phone');
        $inputName = $this->option('name') ?? 'Test User';
        $inputNik = $this->option('nik') ?? '1234567890123456';
        $inputMotherStatus = $this->option('mother') === 'true';

        $this->info('=== Debug Validation Logic ===');
        $this->info('Input data:');
        $this->line("- Phone: {$phone}");
        $this->line("- Name: {$inputName}");
        $this->line("- NIK: {$inputNik}");
        $this->line('- Identity card mother: '.($inputMotherStatus ? 'true' : 'false'));
        $this->line('');

        // Cari existing users dengan phone yang sama
        $existingUsers = User::where('phone', $phone)
            ->where('type_user', 'patient')
            ->with(['userDetail', 'patient'])
            ->get();

        $this->info('Found '.$existingUsers->count().' existing users with this phone');

        foreach ($existingUsers as $existingUser) {
            $this->info("--- Checking against User: {$existingUser->name} ---");

            // Simulasi hasAnyDifferenceInCriteria
            $currentCompanyId = $existingUser->company_id; // Assume same company for now

            // 1. Cek company_id
            $companyDiff = $existingUser->company_id !== $currentCompanyId;
            $this->line('1. Company different: '.($companyDiff ? 'YES' : 'NO'));

            // 2. Cek nama
            $nameMatch = strtolower(trim($inputName)) === strtolower(trim($existingUser->name));
            $nameDiff = ! $nameMatch;
            $this->line('2. Name different: '.($nameDiff ? 'YES' : 'NO')." (input: '{$inputName}' vs existing: '{$existingUser->name}')");

            // 3. Cek NIK
            $nikDiff = false;
            if ($existingUser->userDetail && $existingUser->userDetail->identity_card && $inputNik) {
                try {
                    $existingIdentityCard = Crypt::decryptString($existingUser->userDetail->identity_card);
                    $identityCardMatch = $existingIdentityCard === $inputNik;
                    $nikDiff = ! $identityCardMatch;
                    $maskedExisting = substr($existingIdentityCard, 0, 4).'****'.substr($existingIdentityCard, -4);
                    $maskedInput = substr($inputNik, 0, 4).'****'.substr($inputNik, -4);
                    $this->line('3. NIK different: '.($nikDiff ? 'YES' : 'NO')." (input: '{$maskedInput}' vs existing: '{$maskedExisting}')");
                } catch (\Exception $e) {
                    $nikDiff = true;
                    $this->line('3. NIK different: YES (failed to decrypt existing NIK)');
                }
            } else {
                $nikDiff = true;
                $this->line('3. NIK different: YES (NIK not available for comparison)');
            }

            // 4. Cek status identity_card_mother
            $existingPatient = $existingUser->patient;
            $existingIdentityCardMother = $existingPatient ? $existingPatient->identity_card_mother : false;
            $identityCardMotherMatch = $existingIdentityCardMother === $inputMotherStatus;
            $statusDiff = ! $identityCardMotherMatch;
            $this->line('4. Status different: '.($statusDiff ? 'YES' : 'NO').' (input: '.($inputMotherStatus ? 'mother' : 'self').' vs existing: '.($existingIdentityCardMother ? 'mother' : 'self').')');

            // Hasil final
            $hasAnyDifference = $companyDiff || $nameDiff || $nikDiff || $statusDiff;
            $this->line('');
            $this->line('RESULT: hasAnyDifference = '.($hasAnyDifference ? 'TRUE (ALLOWED)' : 'FALSE (BLOCKED)'));

            if (! $hasAnyDifference) {
                $this->error('VALIDATION WOULD FAIL: All criteria are the same!');
            } else {
                $this->info('VALIDATION WOULD PASS: At least one criteria is different');
            }

            $this->line('');
        }

        return 0;
    }
}
