// File: app/Console/Kernel.php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
protected function schedule(Schedule $schedule)
{
$schedule->command('run:defecta')->dailyAt('00:00');

// Notification checks
$schedule->command('check:defecta-stock')->dailyAt('00:10');
$schedule->command('check:product-expiry')->dailyAt('00:20');
$schedule->command('check:control-schedule')
    ->dailyAt('00:00')
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/control-schedule.log'));
$schedule->command('check:price-product-null')->everyMinute()->withoutOverlapping();

$schedule->command('app:dead-stock-command')->everyTwoHours();
$schedule->command('app:import-stock-command')->everyTwoHours();
$schedule->command('app:purchase-command')->everyTwoHours();
$schedule->command('app:sale-command')->everyTwoHours();
$schedule->command('app:stock-opname-command')->everyTwoHours();
}

protected function commands()
{
$this->load(__DIR__.'/Commands');

require base_path('routes/console.php');
}
}
