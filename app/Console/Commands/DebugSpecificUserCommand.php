<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class DebugSpecificUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:specific-user {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug specific user identity card';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');

        $this->info("=== Debug User: {$userId} ===");

        $user = User::with(['userDetail', 'patient'])->find($userId);

        if (! $user) {
            $this->error('User not found');

            return 1;
        }

        $this->line("Name: {$user->name}");
        $this->line("Phone: {$user->phone}");
        $this->line("Company ID: {$user->company_id}");

        if ($user->userDetail) {
            $this->info('=== User Detail ===');

            $original = $user->userDetail->getRawOriginal('identity_card');
            $this->line('Original (encrypted): '.($original ? substr($original, 0, 50).'...' : 'NULL'));

            try {
                $decrypted = $user->userDetail->identity_card;
                $this->line("Decrypted: {$decrypted}");

                $display = $user->userDetail->identity_card_display;
                $this->line("Display (masked): {$display}");

                // Test manual decrypt
                if ($original) {
                    try {
                        $manualDecrypt = Crypt::decryptString($original);
                        $this->line("Manual decrypt: {$manualDecrypt}");
                    } catch (\Exception $e) {
                        $this->error("Manual decrypt failed: {$e->getMessage()}");
                    }
                }
            } catch (\Exception $e) {
                $this->error("Accessor failed: {$e->getMessage()}");
            }
        } else {
            $this->error('No user detail found');
        }

        if ($user->patient) {
            $this->info('=== Patient ===');
            $this->line('Identity card mother: '.($user->patient->identity_card_mother ? 'true' : 'false'));
        } else {
            $this->error('No patient record found');
        }

        return 0;
    }
}
