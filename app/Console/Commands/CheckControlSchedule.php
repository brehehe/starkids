<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\User\UserControlSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckControlSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:control-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check control schedules and create reminder notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking control schedules for reminders...');

        // Define notification periods: 7 days, 5 days, 2 days, 1 day before, and same day
        $periods = [
            ['days' => 7, 'label' => '7 hari'],
            ['days' => 5, 'label' => '5 hari'],
            ['days' => 2, 'label' => '2 hari'],
            ['days' => 1, 'label' => 'besok'],
            ['days' => 0, 'label' => 'hari ini'],
        ];

        $totalChecked = 0;
        $totalNotifications = 0;

        // Pre-fetch existing notifications for today to avoid duplicates
        $existingNotifications = Notification::withTrashed()
            ->where('type', 'control_schedule')
            ->whereDate('created_at', today())
            ->get(['data'])
            ->map(function ($n) {
                $data = $n->data;

                return "{$data['schedule_id']}|{$data['days_until']}";
            })
            ->flip(); // Flip for O(1) lookup

        foreach ($periods as $period) {
            $targetDate = now()->addDays($period['days'])->format('Y-m-d');
            $this->info("Checking schedules for {$targetDate} ({$period['label']})...");

            // Query schedules for target date
            $schedules = UserControlSchedule::whereDate('date', $targetDate)
                ->where('status', 'draft')
                ->with([
                    'user:id,name',
                    'doctor:id,name',
                    'location:id,name',
                    'transaction:id,status',
                ])
                ->get();

            $totalChecked += $schedules->count();

            foreach ($schedules as $schedule) {
                // Check for duplicate
                $key = "{$schedule->id}|{$period['days']}";
                if ($existingNotifications->has($key)) {
                    continue;
                }

                // Generate appropriate message
                $userName = $schedule->user->name ?? 'Pasien';
                $doctorName = $schedule->doctor->name ?? '-';
                $locationName = $schedule->location->name ?? '-';
                $formattedDate = Carbon::parse($schedule->date)->format('d/m/Y');

                if ($period['days'] == 0) {
                    $message = "{$userName} memiliki jadwal kontrol hari ini dengan {$doctorName} di {$locationName}";
                } elseif ($period['days'] == 1) {
                    $message = "{$userName} memiliki jadwal kontrol besok (tanggal: {$formattedDate}) dengan {$doctorName} di {$locationName}";
                } else {
                    $message = "{$userName} memiliki jadwal kontrol dalam {$period['days']} hari (tanggal: {$formattedDate}) dengan {$doctorName} di {$locationName}";
                }

                try {
                    Notification::create([
                        'company_id' => $schedule->company_id,
                        'branch_id' => null,
                        'name' => 'System',
                        'type' => 'control_schedule',
                        'title' => 'Reminder Jadwal Kontrol',
                        'message' => $message,
                        'data' => [
                            'schedule_id' => $schedule->id,
                            'user_id' => $schedule->user_id,
                            'user_name' => $userName,
                            'doctor_name' => $doctorName,
                            'location' => $locationName,
                            'scheduled_date' => $schedule->date,
                            'days_until' => $period['days'],
                            'status' => $schedule->status,
                            'action_url' => route('user.consultation.date-control'),
                        ],
                        'is_read' => false,
                    ]);

                    $totalNotifications++;
                    $existingNotifications->put($key, true);

                } catch (\Exception $e) {
                    Log::error('Failed to create control schedule notification', [
                        'schedule_id' => $schedule->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            $this->info("Found {$schedules->count()} schedules for {$period['label']}");
        }

        $this->info("Created {$totalNotifications} control schedule notifications.");
        Log::info('CheckControlSchedule completed', [
            'total_checked' => $totalChecked,
            'notifications_created' => $totalNotifications,
        ]);

        return Command::SUCCESS;
    }
}
