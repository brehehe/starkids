<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\User\UserDetail;
use App\Models\Patient\Patient;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class TestConsultationPatientValidationAdvancedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:consultation-patient-validation-advanced
                            {--phone= : Phone number to test}
                            {--email= : Email to test}
                            {--name= : Name to test}
                            {--identity-card= : Identity card to test}
                            {--identity-card-mother= : Identity card mother status (true/false)}
                            {--company-id= : Company ID to test within}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the advanced consultation patient validation logic that allows sharing phone/email if other criteria differ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Advanced Consultation Patient Validation Logic');
        $this->info('=========================================================');

        // Test parameters
        $testPhone = $this->option('phone') ?? '081234567890';
        $testEmail = $this->option('email') ?? 'test@example.com';
        $testName = $this->option('name') ?? 'John Doe';
        $testIdentityCard = $this->option('identity-card') ?? '1234567890123456';
        $testIdentityCardMother = $this->option('identity-card-mother') === 'true';
        $testCompanyId = $this->option('company-id') ?? 1;

        $this->info("Test Parameters:");
        $this->line("Phone: {$testPhone}");
        $this->line("Email: {$testEmail}");
        $this->line("Name: {$testName}");
        $this->line("Identity Card: {$testIdentityCard}");
        $this->line("Identity Card Mother: " . ($testIdentityCardMother ? 'true' : 'false'));
        $this->line("Company ID: {$testCompanyId}");
        $this->line('');

        // Test 1: Find existing users with same phone
        $this->info('1. Testing Phone Number Conflicts');
        $this->line('================================');
        $phoneConflicts = $this->findUsersWithPhone($testPhone, $testCompanyId);
        $this->displayConflicts('Phone', $phoneConflicts, $testName, $testIdentityCard, $testIdentityCardMother);

        // Test 2: Find existing users with same email
        $this->info('2. Testing Email Conflicts');
        $this->line('==========================');
        $emailConflicts = $this->findUsersWithEmail($testEmail, $testCompanyId);
        $this->displayConflicts('Email', $emailConflicts, $testName, $testIdentityCard, $testIdentityCardMother);

        // Test 3: Simulate validation results
        $this->info('3. Validation Results Simulation');
        $this->line('=================================');
        $this->simulateValidation($testPhone, $testEmail, $testName, $testIdentityCard, $testIdentityCardMother, $testCompanyId);

        // Test 4: Show recommendations
        $this->info('4. Recommendations');
        $this->line('==================');
        $this->showRecommendations($phoneConflicts, $emailConflicts);

        return 0;
    }

    /**
     * Find users with the same phone number
     */
    protected function findUsersWithPhone($phone, $companyId)
    {
        return User::where('phone', $phone)
            ->where('type_user', 'patient')
            ->with(['userDetail', 'patient'])
            ->get()
            ->map(function ($user) {
                return $this->formatUserInfo($user);
            });
    }

    /**
     * Find users with the same email
     */
    protected function findUsersWithEmail($email, $companyId)
    {
        return User::where('email', $email)
            ->where('type_user', 'patient')
            ->with(['userDetail', 'patient'])
            ->get()
            ->map(function ($user) {
                return $this->formatUserInfo($user);
            });
    }

    /**
     * Format user information for display
     */
    protected function formatUserInfo($user)
    {
        $identityCard = 'N/A';
        if ($user->userDetail && $user->userDetail->identity_card) {
            try {
                $decrypted = Crypt::decryptString($user->userDetail->identity_card);
                $identityCard = substr($decrypted, 0, 4) . '****' . substr($decrypted, -4);
            } catch (\Exception $e) {
                $identityCard = 'Error decrypting';
            }
        }

        $identityCardMother = $user->patient ? $user->patient->identity_card_mother : false;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'company_id' => $user->company_id,
            'identity_card' => $identityCard,
            'identity_card_mother' => $identityCardMother,
            'deleted_at' => $user->deleted_at
        ];
    }

    /**
     * Display conflicts for a specific field
     */
    protected function displayConflicts($fieldName, $conflicts, $testName, $testIdentityCard, $testIdentityCardMother)
    {
        if ($conflicts->isEmpty()) {
            $this->line("No existing users found with the same {$fieldName}.");
            $this->line('');
            return;
        }

        $this->line("Found {$conflicts->count()} existing user(s) with the same {$fieldName}:");

        foreach ($conflicts as $index => $conflict) {
            $this->line("  " . ($index + 1) . ". User ID: {$conflict['id']}");
            $this->line("     Name: {$conflict['name']}");
            $this->line("     Phone: {$conflict['phone']}");
            $this->line("     Email: {$conflict['email']}");
            $this->line("     Company ID: {$conflict['company_id']}");
            $this->line("     Identity Card: {$conflict['identity_card']}");
            $this->line("     Identity Card Mother: " . ($conflict['identity_card_mother'] ? 'true' : 'false'));
            $this->line("     Status: " . ($conflict['deleted_at'] ? 'Deleted' : 'Active'));

            // Check differences
            $differences = $this->findDifferences($conflict, $testName, $testIdentityCard, $testIdentityCardMother);

            if (empty($differences)) {
                $this->error("     ❌ CONFLICT: No significant differences found - sharing would be REJECTED");
            } else {
                $this->info("     ✅ ALLOWED: Differences found - sharing would be ALLOWED");
                $this->line("     Differences: " . implode(', ', $differences));
            }
            $this->line('');
        }
    }

    /**
     * Find differences between existing user and test data
     */
    protected function findDifferences($existingUser, $testName, $testIdentityCard, $testIdentityCardMother)
    {
        $differences = [];

        // Check name
        if (strtolower(trim($existingUser['name'])) !== strtolower(trim($testName))) {
            $differences[] = 'name different';
        }

        // Check NIK
        if ($existingUser['identity_card'] !== 'N/A' && $existingUser['identity_card'] !== 'Error decrypting') {
            $existingMasked = $existingUser['identity_card'];
            $testMasked = substr($testIdentityCard, 0, 4) . '****' . substr($testIdentityCard, -4);
            if ($existingMasked !== $testMasked) {
                $differences[] = 'NIK different';
            }
        } else {
            $differences[] = 'NIK not available for comparison';
        }

        // Check identity_card_mother status
        if ($existingUser['identity_card_mother'] !== $testIdentityCardMother) {
            $currentStatus = $testIdentityCardMother ? 'NIK Ibu' : 'NIK Sendiri';
            $existingStatus = $existingUser['identity_card_mother'] ? 'NIK Ibu' : 'NIK Sendiri';
            $differences[] = "identity_card_mother different ({$existingStatus} vs {$currentStatus})";
        }

        return $differences;
    }

    /**
     * Simulate validation results
     */
    protected function simulateValidation($phone, $email, $name, $identityCard, $identityCardMother, $companyId)
    {
        // Test phone validation
        $phoneConflicts = $this->findUsersWithPhone($phone, $companyId);
        $phoneAllowed = true;
        $phoneReasons = [];

        foreach ($phoneConflicts as $conflict) {
            $differences = $this->findDifferences($conflict, $name, $identityCard, $identityCardMother);
            if (empty($differences)) {
                $phoneAllowed = false;
                $phoneReasons[] = "Conflict with user ID {$conflict['id']} ({$conflict['name']}) - no significant differences";
            }
        }

        // Test email validation
        $emailConflicts = $this->findUsersWithEmail($email, $companyId);
        $emailAllowed = true;
        $emailReasons = [];

        foreach ($emailConflicts as $conflict) {
            $differences = $this->findDifferences($conflict, $name, $identityCard, $identityCardMother);
            if (empty($differences)) {
                $emailAllowed = false;
                $emailReasons[] = "Conflict with user ID {$conflict['id']} ({$conflict['name']}) - no significant differences";
            }
        }

        // Display results
        $this->line("Phone validation: " . ($phoneAllowed ? '✅ ALLOWED' : '❌ REJECTED'));
        if (!$phoneAllowed) {
            foreach ($phoneReasons as $reason) {
                $this->line("  - {$reason}");
            }
        }

        $this->line("Email validation: " . ($emailAllowed ? '✅ ALLOWED' : '❌ REJECTED'));
        if (!$emailAllowed) {
            foreach ($emailReasons as $reason) {
                $this->line("  - {$reason}");
            }
        }

        $overallAllowed = $phoneAllowed && $emailAllowed;
        $this->line('');
        $this->line("Overall validation: " . ($overallAllowed ? '✅ WOULD BE ALLOWED' : '❌ WOULD BE REJECTED'));
        $this->line('');
    }

    /**
     * Show recommendations
     */
    protected function showRecommendations($phoneConflicts, $emailConflicts)
    {
        if ($phoneConflicts->isEmpty() && $emailConflicts->isEmpty()) {
            $this->info("✅ No conflicts found. The patient can be created without issues.");
            return;
        }

        $this->line("To resolve conflicts, ensure that the new patient differs from existing patients in at least one of:");
        $this->line("  1. Name (case insensitive)");
        $this->line("  2. NIK (Identity Card)");
        $this->line("  3. Status NIK (Identity Card Mother: true/false)");
        $this->line("  4. Company ID");
        $this->line('');
        $this->line("Current validation rules:");
        $this->line("  - NIK must be unique within company (strict rule)");
        $this->line("  - Phone/Email can be shared if other criteria differ");
        $this->line("  - Same NIK + same name + same identity_card_mother status = NOT ALLOWED");
        $this->line("  - Different company = always allowed");
    }
}
