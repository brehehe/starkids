<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\User\UserDetail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class TestConsultationPatientValidationCommand extends Command
{
    protected $signature = 'test:consultation-patient-validation {user_id?}';

    protected $description = 'Test patient validation for consultation module';

    public function handle()
    {
        $userId = $this->argument('user_id');

        if ($userId) {
            $this->testSpecificUser($userId);
        } else {
            $this->testAllValidation();
        }
    }

    private function testSpecificUser($userId)
    {
        $user = User::with(['userDetail', 'patient'])->find($userId);

        if (! $user) {
            $this->error("User dengan ID {$userId} tidak ditemukan");

            return;
        }

        $this->info("=== Testing User ID: {$userId} ===");
        $this->info("Nama: {$user->name}");
        $this->info("Email: {$user->email}");
        $this->info("Phone: {$user->phone}");
        $this->info("Company ID: {$user->company_id}");

        if ($user->userDetail && $user->userDetail->identity_card) {
            try {
                // Coba decrypt dengan format baru
                $decryptedNik = Crypt::decryptString($user->userDetail->identity_card);
                $maskedNik = substr($decryptedNik, 0, 4).str_repeat('*', 8).substr($decryptedNik, -4);
                $this->info("NIK: {$maskedNik}");
            } catch (\Exception $e) {
                // Jika gagal dengan Crypt::decryptString, tampilkan raw data untuk debug
                $encryptedData = $user->userDetail->identity_card;
                $this->info('NIK: [ENCRYPTED - '.strlen($encryptedData).' chars]');
                $this->info('Sample: '.substr($encryptedData, 0, 50).'...');
                $this->error('Gagal decrypt NIK: '.$e->getMessage());
            }
        } else {
            $this->info('NIK: Tidak ada');
        }

        if ($user->patient) {
            $nikStatus = $user->patient->identity_card_mother ? 'NIK Ibu' : 'NIK Sendiri';
            $this->info("Status NIK: {$nikStatus}");
        }

        // Test validation logic
        $this->info("\n=== Testing Validation Logic ===");
        $this->testEmailValidation($user);
        $this->testPhoneValidation($user);
        $this->testNikValidation($user);
    }

    private function testAllValidation()
    {
        $this->info('=== Testing All Patient Validation ===');

        $patients = User::where('type_user', 'patient')
            ->with(['userDetail', 'patient'])
            ->limit(10)
            ->get();

        foreach ($patients as $user) {
            $this->info("\n--- User: {$user->name} (ID: {$user->id}) ---");

            if ($user->userDetail && $user->userDetail->identity_card) {
                try {
                    $decryptedNik = Crypt::decryptString($user->userDetail->identity_card);
                    $maskedNik = substr($decryptedNik, 0, 4).str_repeat('*', 8).substr($decryptedNik, -4);
                    $this->info("NIK: {$maskedNik}");
                } catch (\Exception $e) {
                    $this->error('Gagal decrypt NIK: '.$e->getMessage());
                }
            }
        }
    }

    private function testEmailValidation($user)
    {
        if (! $user->email) {
            $this->info('Email: Tidak ada email untuk ditest');

            return;
        }

        // Cari users lain dengan email yang sama
        $duplicates = User::where('email', $user->email)
            ->where('type_user', 'patient')
            ->where('id', '!=', $user->id)
            ->with(['userDetail', 'patient'])
            ->get();

        $this->info("Email '{$user->email}' - Duplikasi ditemukan: ".$duplicates->count());

        foreach ($duplicates as $duplicate) {
            $differences = $this->findDifferences($user, $duplicate);
            $this->info("  -> {$duplicate->name} (ID: {$duplicate->id}) - Perbedaan: ".implode(', ', $differences));
        }
    }

    private function testPhoneValidation($user)
    {
        if (! $user->phone) {
            $this->info('Phone: Tidak ada phone untuk ditest');

            return;
        }

        // Cari users lain dengan phone yang sama
        $duplicates = User::where('phone', $user->phone)
            ->where('type_user', 'patient')
            ->where('id', '!=', $user->id)
            ->with(['userDetail', 'patient'])
            ->get();

        $this->info("Phone '{$user->phone}' - Duplikasi ditemukan: ".$duplicates->count());

        foreach ($duplicates as $duplicate) {
            $differences = $this->findDifferences($user, $duplicate);
            $this->info("  -> {$duplicate->name} (ID: {$duplicate->id}) - Perbedaan: ".implode(', ', $differences));
        }
    }

    private function testNikValidation($user)
    {
        if (! $user->userDetail || ! $user->userDetail->identity_card) {
            $this->info('NIK: Tidak ada NIK untuk ditest');

            return;
        }

        try {
            $userNik = null;

            try {
                // Coba decrypt dulu (untuk data yang sudah terenkripsi)
                $userNik = Crypt::decryptString($user->userDetail->identity_card);
            } catch (\Exception $e) {
                // Jika gagal decrypt, kemungkinan plain text
                if (strlen($user->userDetail->identity_card) === 16 && is_numeric($user->userDetail->identity_card)) {
                    $userNik = $user->userDetail->identity_card;
                } else {
                    $this->error('Gagal decrypt NIK user dan bukan format plain text: '.$e->getMessage());

                    return;
                }
            }
        } catch (\Exception $e) {
            $this->error('Gagal mendapatkan NIK user: '.$e->getMessage());

            return;
        }

        // Cari users lain dengan NIK yang sama
        $allUserDetails = UserDetail::with(['user.patient'])->get();
        $duplicates = collect();

        foreach ($allUserDetails as $userDetail) {
            if (! $userDetail->identity_card || $userDetail->user_id === $user->id) {
                continue;
            }

            try {
                $otherNik = null;

                try {
                    // Coba decrypt dulu (untuk data yang sudah terenkripsi)
                    $otherNik = Crypt::decryptString($userDetail->identity_card);
                } catch (\Exception $e) {
                    // Jika gagal decrypt, kemungkinan plain text
                    if (strlen($userDetail->identity_card) === 16 && is_numeric($userDetail->identity_card)) {
                        $otherNik = $userDetail->identity_card;
                    } else {
                        continue; // Skip jika tidak bisa decrypt dan bukan plain text
                    }
                }

                if ($otherNik === $userNik && $userDetail->user->type_user === 'patient') {
                    $duplicates->push($userDetail->user);
                }
            } catch (\Exception $e) {
                // Skip jika tidak bisa decrypt
            }
        }

        $maskedNik = substr($userNik, 0, 4).str_repeat('*', 8).substr($userNik, -4);
        $this->info("NIK '{$maskedNik}' - Duplikasi ditemukan: ".$duplicates->count());

        foreach ($duplicates as $duplicate) {
            $differences = $this->findDifferences($user, $duplicate);
            $this->info("  -> {$duplicate->name} (ID: {$duplicate->id}) - Perbedaan: ".implode(', ', $differences));
        }
    }

    private function findDifferences($user1, $user2)
    {
        $differences = [];

        // 1. Company ID
        if ($user1->company_id !== $user2->company_id) {
            $differences[] = 'company berbeda';
        }

        // 2. Nama
        if (strtolower(trim($user1->name)) !== strtolower(trim($user2->name))) {
            $differences[] = 'nama berbeda';
        }

        // 3. NIK
        $nik1 = null;
        $nik2 = null;

        if ($user1->userDetail && $user1->userDetail->identity_card) {
            try {
                $nik1 = Crypt::decryptString($user1->userDetail->identity_card);
            } catch (\Exception $e) {
                // Skip
            }
        }

        if ($user2->userDetail && $user2->userDetail->identity_card) {
            try {
                $nik2 = Crypt::decryptString($user2->userDetail->identity_card);
            } catch (\Exception $e) {
                // Skip
            }
        }

        if ($nik1 && $nik2 && $nik1 !== $nik2) {
            $differences[] = 'NIK berbeda';
        } elseif (! $nik1 || ! $nik2) {
            $differences[] = 'NIK tidak tersedia untuk perbandingan';
        }

        // 4. Status identity_card_mother
        $status1 = $user1->patient ? $user1->patient->identity_card_mother : false;
        $status2 = $user2->patient ? $user2->patient->identity_card_mother : false;

        if ($status1 !== $status2) {
            $currentStatus = $status1 ? 'NIK Ibu' : 'NIK Sendiri';
            $existingStatus = $status2 ? 'NIK Ibu' : 'NIK Sendiri';
            $differences[] = "status NIK berbeda ({$currentStatus} vs {$existingStatus})";
        }

        return empty($differences) ? ['SEMUA SAMA'] : $differences;
    }
}
