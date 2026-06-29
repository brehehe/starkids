<?php

namespace App\Console\Commands;

use App\Models\User\UserDetail;
use Illuminate\Console\Command;

class TestAllIdentityCardDisplayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:all-identity-card-display';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test identity card display accessor for all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing identity card display accessor for all users...');

        $userDetails = UserDetail::whereNotNull('identity_card')
            ->where('identity_card', '!=', '')
            ->limit(5)
            ->get();

        if ($userDetails->count() === 0) {
            $this->error('No user details with identity_card found');

            return 1;
        }

        $this->info("Found {$userDetails->count()} user details with identity_card");

        foreach ($userDetails as $userDetail) {
            $this->info("=== Testing User ID: {$userDetail->user_id} ===");

            try {
                $original = $userDetail->getRawOriginal('identity_card');
                $this->line('Original (encrypted): '.substr($original, 0, 50).'...');

                $decrypted = $userDetail->identity_card;
                $this->line("Decrypted: {$decrypted}");

                $display = $userDetail->identity_card_display;
                $this->line("Display (masked): {$display}");

                $this->line(''); // Empty line for separation
            } catch (\Exception $e) {
                $this->error("Error for User ID {$userDetail->user_id}: {$e->getMessage()}");
            }
        }

        $this->info('Test completed!');

        return 0;
    }
}
