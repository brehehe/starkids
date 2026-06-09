<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Transaction\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckPendingPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:pending-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check pending transactions that are not paid and create notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Checking pending payments...");

        // Group by company to send summary notification per company
        $pendingTransactions = Transaction::where('is_pending_payment', true)
            ->where('status_payment', '!=', 'paid')
            ->select('company_id', DB::raw('count(*) as total_count'), DB::raw('sum(grand_total_price - COALESCE(payment_amount, 0)) as total_unpaid'))
            ->groupBy('company_id')
            ->get();

        $notificationCount = 0;

        foreach ($pendingTransactions as $pending) {
            if ($pending->total_count <= 0) continue;

            $companyId = $pending->company_id;
            $count = $pending->total_count;
            $totalUnpaid = $pending->total_unpaid;

            // Check if notification already exists for today to avoid duplicates if run multiple times
            $exists = Notification::where('type', 'pending_payment')
                ->where('company_id', $companyId)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($exists) {
                continue;
            }

            try {
                $title = 'Tagihan Belum Lunas';
                $message = sprintf(
                    'Terdapat %d transaksi belum lunas dengan total tagihan Rp %s. Segera selesaikan pembayaran.',
                    $count,
                    number_format($totalUnpaid, 0, ',', '.')
                );

                Notification::create([
                    'company_id' => $companyId,
                    'branch_id' => null, // Global for company
                    'name' => 'System',
                    'type' => 'pending_payment',
                    'title' => $title,
                    'message' => $message,
                    'data' => [
                        'total_count' => $count,
                        'total_unpaid' => $totalUnpaid,
                        'action_url' => route('user.sale.pending'), // As requested
                    ],
                    'is_read' => false,
                ]);

                $notificationCount++;
                $this->info("Created notification for Company ID {$companyId}");

            } catch (\Exception $e) {
                Log::error('Failed to create pending payment notification', [
                    'company_id' => $companyId,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("Created {$notificationCount} pending payment notifications.");
        Log::info("CheckPendingPayment completed", [
            'notifications_created' => $notificationCount
        ]);

        return Command::SUCCESS;
    }
}
