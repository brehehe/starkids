<?php

namespace App\Console\Commands;

use App\Models\User\UserDetail;
use Illuminate\Console\Command;

class TestIdentityCardDisplayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:identity-card-display';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test identity card display accessor';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing identity card display accessor...');

        $userDetail = UserDetail::first();

        if (!$userDetail) {
            $this->error('No user detail found');
            return 1;
        }

        $this->info("Testing with User ID: {$userDetail->user_id}");

        try {
            $original = $userDetail->getRawOriginal('identity_card');
            $this->line("Original (encrypted): {$original}");

            $decrypted = $userDetail->identity_card;
            $this->line("Decrypted: {$decrypted}");

            $display = $userDetail->identity_card_display;
            $this->line("Display (masked): {$display}");

            $this->info('Test completed successfully!');
        } catch (\Exception $e) {
            $this->error("Error: {$e->getMessage()}");
            return 1;
        }

        return 0;
    }
}
