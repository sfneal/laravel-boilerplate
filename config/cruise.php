<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auto commit version bumps
    |--------------------------------------------------------------------------
    |
    | This option allows you to configure the 'php artisan bump' command to
    | commit changes version files (version.txt & docker compose) to git after
    | running a version bump.
    |
    | Enabling this option auto commits your version files without providing
    | the '--commit' flag to the 'php artisan bump' command
    |
    */
    'bump' => [
        'auto-commit' => false,
    ],
];
