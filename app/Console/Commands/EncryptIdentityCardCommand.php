<?php

namespace App\Console\Commands;

use App\Models\User\UserDetail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class EncryptIdentityCardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encrypt:identity-cards {--dry-run : Show what would be encrypted without actually doing it} {--force : Force encryption even if already encrypted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Encrypt all identity_card fields in user_details table that are not yet encrypted';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        $this->info('Starting identity card encryption process...');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        // Get all user details with identity_card
        $userDetails = UserDetail::whereNotNull('identity_card')
            ->where('identity_card', '!=', '')
            ->get();

        $this->info("Found {$userDetails->count()} user details with identity_card data");

        $encrypted = 0;
        $alreadyEncrypted = 0;
        $errors = 0;

        $progressBar = $this->output->createProgressBar($userDetails->count());
        $progressBar->start();

        foreach ($userDetails as $userDetail) {
            try {
                $identityCard = $userDetail->identity_card;

                // Check if already encrypted by trying to decrypt
                $isAlreadyEncrypted = false;
                if (!$force) {
                    try {
                        Crypt::decryptString($identityCard);
                        $isAlreadyEncrypted = true;
                    } catch (\Exception $e) {
                        // Not encrypted, proceed with encryption
                        $isAlreadyEncrypted = false;
                    }
                }

                if ($isAlreadyEncrypted && !$force) {
                    $alreadyEncrypted++;
                    $this->line("\nUser ID {$userDetail->user_id}: Already encrypted");
                } else {
                    // Encrypt the identity card
                    $encryptedIdentityCard = Crypt::encryptString($identityCard);

                    if (!$dryRun) {
                        DB::beginTransaction();
                        try {
                            $userDetail->update([
                                'identity_card' => $encryptedIdentityCard
                            ]);
                            DB::commit();
                            $encrypted++;
                            $this->line("\nUser ID {$userDetail->user_id}: Encrypted successfully");
                        } catch (\Exception $e) {
                            DB::rollBack();
                            $errors++;
                            $this->error("\nUser ID {$userDetail->user_id}: Failed to encrypt - {$e->getMessage()}");
                        }
                    } else {
                        $encrypted++;
                        $maskedOriginal = $this->maskIdentityCard($identityCard);
                        $this->line("\nUser ID {$userDetail->user_id}: Would encrypt '{$maskedOriginal}'");
                    }
                }
            } catch (\Exception $e) {
                $errors++;
                $this->error("\nUser ID {$userDetail->user_id}: Error processing - {$e->getMessage()}");
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Summary
        $this->info('Encryption process completed!');
        $this->table(
            ['Status', 'Count'],
            [
                ['Encrypted', $encrypted],
                ['Already Encrypted', $alreadyEncrypted],
                ['Errors', $errors],
                ['Total Processed', $userDetails->count()]
            ]
        );

        if ($dryRun) {
            $this->warn('This was a DRY RUN - no actual changes were made.');
            $this->info('Run without --dry-run to perform actual encryption.');
        }

        if ($errors > 0) {
            $this->error("There were {$errors} errors during processing. Please check the output above.");
            return 1;
        }

        return 0;
    }

    /**
     * Mask identity card for display purposes
     */
    private function maskIdentityCard($identityCard)
    {
        if (strlen($identityCard) < 8) {
            return str_repeat('*', strlen($identityCard));
        }

        return substr($identityCard, 0, 4) . str_repeat('*', strlen($identityCard) - 8) . substr($identityCard, -4);
    }
}
