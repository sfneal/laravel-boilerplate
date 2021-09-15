<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    |
    | This option allows you to set your application's version that can be
    | used within your application
    |
    | Supported: string|null (example: "1.2.4")
    |
    */
    'version' => file_get_contents(base_path('version.txt')),

    /*
    |--------------------------------------------------------------------------
    | Changelog Path
    |--------------------------------------------------------------------------
    |
    | // todo: add support for markdowns
    | Set the path to a txt file changelog.
    |
    | Supported: string|null
    |
    */
    'changelog_path' => base_path('changelog.txt'),

    /*
    |--------------------------------------------------------------------------
    | Cache Prefix
    |--------------------------------------------------------------------------
    |
    | Prefix when generating cache key's for storing application info.
    |
    | Supported: string
    |
    */
    'cache_prefix' => 'app',
];
