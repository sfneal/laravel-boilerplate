<?php

namespace App\Console;

use App\Console\Commands\CacheViewsCommand;
use Domain\Plans\Jobs\BatchProcessPlansJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Sfneal\Tracking\Jobs\CleanDevTrackingJob;
use Support\Backups\BackupDbJob;
use Support\Dropbox\Commands\SyncProjectFilesToDropboxCommand;
use Support\Jobs\Jobs\RetryAllFailedJobsJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SyncProjectFilesToDropboxCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Remove traffic from `track_traffic` table that originated from a 'Development' environment
        $schedule->job(CleanDevTrackingJob::class)
            ->environments('production')
            ->daily();

        // Render Billable Projects views
        $schedule->command(CacheViewsCommand::class, ['portal'])
            ->twiceDaily('5', '17');

        // Retry All Failed Jobs every 6 hours
        $schedule->job(RetryAllFailedJobsJob::class)
            ->environments('production')
            ->everyThirtyMinutes();

        // Update Plan PDF to use current year copyright
        $schedule->job(new BatchProcessPlansJob('complete', 38))
            ->environments('production')
            ->yearlyOn(1, 1);
        $schedule->job(new BatchProcessPlansJob('review', 38))
            ->environments('production')
            ->yearlyOn(1, 1);

        // Run Daily Database Backups at 2am
        $schedule->job(BackupDbJob::class)
            ->onOneServer()
            ->environments('production')
            ->dailyAt('2:00');
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
