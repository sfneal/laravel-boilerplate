<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Sfneal\Helpers\Laravel\AppInfo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Override Laravel 8's Tailwind paginator
        Paginator::useBootstrap();

        Schema::defaultStringLength(191);

        // Log DB queries for
        // todo: create helper function or package functionality
        if (AppInfo::isEnvDevelopment() && env('DB_QUERY_LOGGING')) {
            DB::listen(function ($query) {
                // Don't log query if it contains an exclusion string
                if (empty(array_filter(
                    // todo: create config value
                    explode(' ', env('DB_QUERY_LOGGING_EXCLUSIONS')),
                    function ($string) use ($query) {
                        if (inString($query->sql, $string)) {
                            return true;
                        }
                    }
                ))) {
                    Log::channel('query')->info(json_encode([Str::replaceArray('?', $query->bindings, $query->sql), $query->time]));
                }
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
