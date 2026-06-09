<?php

namespace App\Console\Commands\Defecta;

use App\Services\Defecta\DefectaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DefectaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:defecta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menjalankan service defecta sekali sehari';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $defectaService = new DefectaService();
        $defectaService->runDefecta();

        $this->info('Defecta service berhasil dijalankan.');
        Log::info('Defecta service berhasil dijalankan.');

        // Notification Logic
        $this->info("Checking for new defects to notify...");

        $defectaCounts = \App\Models\Defecta\Defecta::where('status', 'new')
             ->whereDate('updated_at', \Carbon\Carbon::today())
             ->select('company_id', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
             ->groupBy('company_id')
             ->get();

        foreach ($defectaCounts as $defecta) {
            if ($defecta->count <= 0) continue;

            $companyId = $defecta->company_id;

            // Avoid duplicate notifications for today
            $exists = \App\Models\Notification::where('type', 'defecta')
                ->where('company_id', $companyId)
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->exists();

            if ($exists) continue;

            try {
                \App\Models\Notification::create([
                    'company_id' => $companyId,
                    'branch_id' => null,
                    'name' => 'System',
                    'type' => 'defecta', // Type for icon mapping
                    'title' => 'Stok Menipis (Defecta)',
                    'message' => sprintf(
                        'Terdapat %d produk dengan stok di bawah batas minimal. Segera lakukan pemesanan.',
                        $defecta->count
                    ),
                    'data' => [
                        'count' => $defecta->count,
                        'action_url' => route('user.purchase.defecta'),
                    ],
                    'is_read' => false,
                ]);

                $this->info("Created defecta notification for Company ID {$companyId}");

            } catch (\Exception $e) {
                Log::error('Failed to create defecta notification', [
                    'company_id' => $companyId,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
