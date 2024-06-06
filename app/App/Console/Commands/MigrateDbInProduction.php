<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Sfneal\Helpers\Laravel\AppInfo;

class MigrateDbInProduction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:prod';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the database migrations in production';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (AppInfo::isEnvProduction()) {
            $this->info("Running database migrations because the app env is 'production'.");
            Artisan::call('migrate --force');

            return 0;
        }

        $this->info("Skipped running database migrations because the app env is NOT 'production'.");

        return 1;
    }
}
