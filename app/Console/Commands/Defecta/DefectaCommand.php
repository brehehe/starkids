<?php

namespace App\Console\Commands\Defecta;

use App\Models\Defecta\Defecta;
use App\Models\Notification;
use App\Services\Defecta\DefectaService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
        $defectaService = new DefectaService;
        $defectaService->runDefecta();

        $this->info('Defecta service berhasil dijalankan.');
        Log::info('Defecta service berhasil dijalankan.');

        // Notification Logic
        $this->info('Checking for new defects to notify...');

        $defectaCounts = Defecta::where('status', 'new')
            ->whereDate('updated_at', Carbon::today())
            ->select('company_id', DB::raw('count(*) as count'))
            ->groupBy('company_id')
            ->get();

        foreach ($defectaCounts as $defecta) {
            if ($defecta->count <= 0) {
                continue;
            }

            $companyId = $defecta->company_id;

            // Avoid duplicate notifications for today
            $exists = Notification::where('type', 'defecta')
                ->where('company_id', $companyId)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($exists) {
                continue;
            }

            try {
                Notification::create([
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
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
