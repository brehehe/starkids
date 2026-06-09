<?php

namespace App\Console\Commands;

use App\Livewire\Admin\Consultation\Patient\AdminConsultationPatientIndex;
use Illuminate\Console\Command;
use App\Models\User;

class TestValidationInActionCommand extends Command
{
    protected $signature = 'test:validation-in-action {user_id?}';
    protected $description = 'Test validation directly using AdminConsultationPatientIndex component';

    public function handle()
    {
        try {
            $userId = $this->argument('user_id');

            if (!$userId) {
                $user = User::where('type_user', 'patient')->with('userDetail')->first();
                $userId = $user->id;
            } else {
                $user = User::find($userId);
            }

            if (!$user) {
                $this->error('User not found!');
                return;
            }

            $this->info("Testing dengan User: {$user->name} (ID: {$user->id})");

            // Simulasi data form
            $testData = [
                'name' => $user->name,
                'email' => $user->email ?? 'test@example.com',
                'phone' => $user->phone ?? '081234567890',
                'identity_card' => $user->userDetail->identity_card ?? '1234567890123456',
                'identity_card_mother' => $user->userDetail->identity_card_mother ?? false,
                'company_id' => $user->company_id,
            ];

            $this->info('Data yang akan divalidasi:');
            foreach ($testData as $key => $value) {
                $this->line("  {$key}: {$value}");
            }

            // Buat instance component tanpa mount (yang memerlukan Auth)
            $component = new AdminConsultationPatientIndex();

            // Set properties yang diperlukan untuk validasi
            $component->name = $testData['name'];
            $component->identity_card = $testData['identity_card'];
            $component->identity_card_mother = $testData['identity_card_mother'];
            $component->company_id = $testData['company_id']; // Tambahan untuk fallback
            $component->data_id = null; // Untuk user baru

            // Test validasi email
            $this->info("\n=== Testing Email Validation ===");
            try {
                $emailValidation = $component->validateUniqueContactInfo(
                    'email',
                    $testData['email'],
                    $testData['company_id']
                );
                $this->line("Email validation result: " . ($emailValidation ? 'VALID' : 'INVALID (duplicate found)'));
            } catch (\Exception $e) {
                $this->error("Email validation error: " . $e->getMessage());
            }

            // Test validasi phone
            $this->info("\n=== Testing Phone Validation ===");
            try {
                $phoneValidation = $component->validateUniqueContactInfo(
                    'phone',
                    $testData['phone'],
                    $testData['company_id']
                );
                $this->line("Phone validation result: " . ($phoneValidation ? 'VALID' : 'INVALID (duplicate found)'));
            } catch (\Exception $e) {
                $this->error("Phone validation error: " . $e->getMessage());
            }

            // Test validasi NIK
            $this->info("\n=== Testing NIK Validation ===");
            try {
                $nikValidation = $component->validateUniqueContactInfo(
                    'identity_card',
                    $testData['identity_card'],
                    $testData['company_id']
                );
                $this->line("NIK validation result: " . ($nikValidation ? 'VALID' : 'INVALID (duplicate found)'));
            } catch (\Exception $e) {
                $this->error("NIK validation error: " . $e->getMessage());
            }

            $this->info("\n=== Test Complete ===");
        } catch (\Exception $e) {
            $this->error("Fatal error: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
        }
    }
}
