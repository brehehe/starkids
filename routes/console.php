<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('run:defecta')->dailyAt('00:00')->withoutOverlapping();

Schedule::command('check:defecta-stock')->dailyAt('00:10')->withoutOverlapping();
Schedule::command('check:product-expiry')->dailyAt('00:20')->withoutOverlapping();
Schedule::command('check:control-schedule')->dailyAt('00:30')->withoutOverlapping();
Schedule::command('check:pending-payment')->lastDayOfMonth('00:30')->withoutOverlapping();

Schedule::command('check:price-product-null')->dailyAt('00:40')->withoutOverlapping();
Schedule::command('app:dead-stock-command')->everyTwoHours()->withoutOverlapping();
Schedule::command('app:import-stock-command')->everyTwoHours()->withoutOverlapping();
Schedule::command('app:purchase-command')->everyTwoHours()->withoutOverlapping();
Schedule::command('app:sale-command')->everyTwoHours()->withoutOverlapping();
Schedule::command('app:stock-opname-command')->everyTwoHours()->withoutOverlapping();

Schedule::command('app:api-outbox-daemon')->everyMinute()->withoutOverlapping();

Schedule::command('backup:run')->dailyAt('00:00')->withoutOverlapping();
