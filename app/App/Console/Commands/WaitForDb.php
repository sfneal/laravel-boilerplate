<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WaitForDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:wait {--max-attempts=20} {--interval=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wait for the DB connection to become available';

    /**
     * Execute the console command.
     *
     *
     * @throws Exception
     */
    public function handle(): int
    {
        $start = now();

        $this->info('Waiting for the DB connection to become available.');

        foreach (range(1, $this->option('max-attempts')) as $attempt) {
            try {
                DB::connection()->getPdo();
                $time = now()->diffInSeconds($start);
                $this->info("Took {$time} seconds to connect to the DB.");

                return 0;
            } catch (Exception $exception) {
                if ($attempt == $this->option('max-attempts')) {
                    throw $exception;
                }

                $this->info("Connect to DB attempt #{$attempt} failed, trying again in {$this->option('interval')} seconds");
                sleep($this->option('interval'));
            }
        }

        return 1;
    }
}
