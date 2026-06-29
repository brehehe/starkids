<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class DebugPhoneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:phone {phone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug phone number conflicts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $phone = $this->argument('phone');

        $this->info('=== Debug Phone Number Conflict ===');
        $this->info("Searching for phone: {$phone}");

        $users = User::where('phone', $phone)
            ->where('type_user', 'patient')
            ->with(['userDetail', 'patient'])
            ->get();

        $this->info('Found '.$users->count().' users with this phone number');
        $this->line('');

        foreach ($users as $user) {
            $this->info("--- User ID: {$user->id} ---");
            $this->line("Name: {$user->name}");
            $this->line("Company ID: {$user->company_id}");
            $this->line("Phone: {$user->phone}");
            $this->line("Email: {$user->email}");
            $this->line('Deleted at: '.($user->deleted_at ? $user->deleted_at->format('Y-m-d H:i:s') : 'null'));

            if ($user->patient) {
                $this->line('Identity card mother: '.($user->patient->identity_card_mother ? 'true' : 'false'));
            } else {
                $this->line('Patient record: null');
            }

            if ($user->userDetail && $user->userDetail->identity_card) {
                try {
                    $decryptedNik = Crypt::decryptString($user->userDetail->identity_card);
                    $maskedNik = substr($decryptedNik, 0, 4).'****'.substr($decryptedNik, -4);
                    $this->line("NIK: {$maskedNik}");
                } catch (\Exception $e) {
                    $this->line('NIK: failed to decrypt');
                }
            } else {
                $this->line('NIK: null');
            }

            $this->line('');
        }

        return 0;
    }
}
