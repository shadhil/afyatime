<?php

namespace App\Console;

use App\Jobs\SendEmailJob;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DailyReminder::class,
        Commands\SubscriptionCheck::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // /usr/local/bin/php /home/shadhil/Codez/Webz/GROWCRM/application/artisan schedule:run >> /dev/null 2>&1

        $schedule->command('subscription:check')->daily();
        $schedule->command('reminder:daily')->everyMinute();
        // $schedule->command('reminder:daily')->twiceDaily(5, 8);
        // $schedule->command('inspire')->hourly();
        // $now = Carbon::now();
        // $month = $now->format('F');
        // $year = $now->format('yy');

        // $fourthFridayMonthly = new Carbon('fourth friday of ' . $month . ' ' . $year);

        // $schedule->job(new SendEmailJob)->dailyAt('10:23');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
