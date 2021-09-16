<?php

namespace App\Console;

use App\Console\Commands\CacheViewsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Sfneal\Tracking\Jobs\CleanDevTrackingJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Retry All Failed Jobs every 6 hours
//        $schedule->job(RetryAllFailedJobsJob::class)
//            ->environments('production')
//            ->everyThirtyMinutes();

        // Run Daily Database Backups at 2am
//        $schedule->job(BackupDbJob::class)
//            ->onOneServer()
//            ->environments('production')
//            ->dailyAt('2:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
