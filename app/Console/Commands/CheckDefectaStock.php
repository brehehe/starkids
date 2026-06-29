<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckDefectaStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:defecta-stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check products with low stock (defecta) and create notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking defecta stock...');

        // Get defectas where stock is below minimum
        // Join with product_stocks to get current quantity
        $lowStockProducts = \DB::table('defectas')
            ->join('product_stocks', 'defectas.product_stock_id', '=', 'product_stocks.id')
            ->join('products', 'defectas.product_id', '=', 'products.id')
            ->select(
                'defectas.*',
                'product_stocks.quantity',
                'products.name as product_name',
                'defectas.company_id',
                'defectas.branch_id'
            )
            ->whereRaw('product_stocks.quantity < defectas.minimum_stock')
            ->where('product_stocks.quantity', '>', 0)
            ->whereNull('defectas.deleted_at')
            ->get();

        $notificationCount = 0;

        foreach ($lowStockProducts as $stock) {
            // Check if notification already exists for this product today
            $existingNotification = Notification::where('type', 'defecta')
                ->where('data->product_id', $stock->product_id)
                ->where('data->branch_id', $stock->branch_id)
                ->whereDate('created_at', today())
                ->first();

            if ($existingNotification) {
                continue; // Skip if already notified today
            }

            try {
                Notification::create([
                    'company_id' => $stock->company_id,
                    'branch_id' => $stock->branch_id,
                    'type' => 'defecta',
                    'title' => 'Stok Menipis (Defecta)',
                    'message' => sprintf(
                        '%s stok tersisa %d (minimum: %d)',
                        $stock->product_name,
                        $stock->quantity,
                        $stock->minimum_stock
                    ),
                    'data' => [
                        'product_id' => $stock->product_id,
                        'product_name' => $stock->product_name,
                        'branch_id' => $stock->branch_id,
                        'current_stock' => $stock->quantity,
                        'minimum_stock' => $stock->minimum_stock,
                        'shortage' => $stock->minimum_stock - $stock->quantity,
                    ],
                    'is_read' => false,
                ]);

                $notificationCount++;

            } catch (\Exception $e) {
                Log::error('Failed to create defecta notification', [
                    'product_id' => $stock->product_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->info("Created {$notificationCount} defecta notifications.");
        Log::info('CheckDefectaStock completed', [
            'total_checked' => $lowStockProducts->count(),
            'notifications_created' => $notificationCount,
        ]);

        return Command::SUCCESS;
    }
}
