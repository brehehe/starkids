<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Product\ProductExpiredDate;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckProductExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:product-expiry {--days=30 : Days before expiry to warn}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check products nearing expiry and create notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysWarning = (int) $this->option('days');
        $this->info("Checking products expiring within {$daysWarning} days...");

        // Get products expiring within specified days
        // $expiringProducts = ProductExpiredDate::whereBetween('expired_date', [
        //         now(),
        //         now()->addDays($daysWarning)
        //     ])
        //     ->whereHas('product')
        //     ->with(['product.company', 'product'])
        //     ->get();

        // Pre-fetch existing notifications for today to avoid N+1 queries
        $existingNotifications = Notification::withTrashed()
            ->where('type', 'product_expiry')
            ->whereDate('created_at', today())
            ->get(['data']) // Only fetch data column
            ->map(function ($n) {
                $data = $n->data;
                $batch = $data['batch_number'] ?? '-';
                $status = $data['status'] ?? '';
                $expiredDate = $data['expired_date'] ?? '';

                return "{$data['product_id']}|{$batch}|{$expiredDate}|{$status}";
            })
            ->flip(); // Flip for O(1) lookup

        $notificationCount = 0;
        $totalChecked = 0;

        ProductExpiredDate::select(['id', 'product_id', 'expired_date', 'batch_number'])
            ->whereBetween('expired_date', [
                now()->subDays($daysWarning),
                now()->addDays($daysWarning),
            ])
            ->whereHas('product')
            ->with(['product:id,name,company_id']) // Eager load only necessary columns
            ->chunk(100, function ($expiringProducts) use ($existingNotifications, &$notificationCount, &$totalChecked) {
                $totalChecked += $expiringProducts->count();
                $notificationsToCreate = [];

                foreach ($expiringProducts as $expired) {
                    if (! $expired->product) {
                        continue;
                    }

                    $daysUntilExpiry = now()->diffInDays($expired->expired_date, false);

                    // Determine status and message
                    if ($daysUntilExpiry < 0) {
                        $status = 'expired';
                        $title = 'Produk Sudah Kadaluarsa';
                        $message = sprintf(
                            '%s (Batch: %s) sudah kadaluarsa %d hari lalu (tanggal: %s)',
                            $expired->product->name,
                            $expired->batch_number ?? '-',
                            abs($daysUntilExpiry),
                            Carbon::parse($expired->expired_date)->format('d/m/Y')
                        );
                    } else {
                        $status = 'warning';
                        $title = 'Produk Akan Kadaluarsa';
                        $message = sprintf(
                            '%s (Batch: %s) akan kadaluarsa dalam %d hari (tanggal: %s)',
                            $expired->product->name,
                            $expired->batch_number ?? '-',
                            $daysUntilExpiry,
                            Carbon::parse($expired->expired_date)->format('d/m/Y')
                        );
                    }

                    // Check duplicate using memory lookup
                    $expiredDateStr = Carbon::parse($expired->expired_date)->format('Y-m-d');
                    $key = "{$expired->product_id}|".($expired->batch_number ?? '-')."|{$expiredDateStr}|{$status}";
                    if ($existingNotifications->has($key)) {
                        continue;
                    }

                    // Add to batch insert array
                    // Note: insert() doesn't trigger model events (creating), so we manually set attributes
                    // However, to keep it simple and safe with Model events (like UUID creation if not using traits properly),
                    // we'll stick to create() but it's much faster now without the inner query.
                    // For massive speedup, insert() is better, but requires manual ID generation if not database-side.
                    // Let's stick to create() loop for safety but the heavy N+1 query is gone.

                    try {
                        Notification::create([
                            'company_id' => $expired->product->company_id,
                            'branch_id' => null,
                            'name' => 'System',
                            'type' => 'product_expiry',
                            'title' => $title,
                            'message' => $message,
                            'data' => [
                                'product_id' => $expired->product_id,
                                'product_name' => $expired->product->name,
                                'expired_date' => Carbon::parse($expired->expired_date)->format('Y-m-d'),
                                'batch_number' => $expired->batch_number,
                                'days_until_expiry' => $daysUntilExpiry,
                                'status' => $status,
                                'action_url' => route('user.purchase.expired-date'),
                            ],
                            'is_read' => false,
                        ]);
                        $notificationCount++;

                        // Add to local cache to prevent duplicate processing within same execution if duplicates exist in source
                        $existingNotifications->put($key, true);

                    } catch (\Exception $e) {
                        Log::error('Failed to create expiry notification', [
                            'product_id' => $expired->product_id,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

        $this->info("Created {$notificationCount} expiry notifications.");
        Log::info('CheckProductExpiry completed', [
            'total_checked' => $totalChecked,
            'notifications_created' => $notificationCount,
        ]);

        return Command::SUCCESS;
    }
}
