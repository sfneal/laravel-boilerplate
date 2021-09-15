<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Temp File expiration
    |--------------------------------------------------------------------------
    |
    | Time for temp URLs generated for AWS S3 files to expire.
    |
    | Supported: "\DateTimeInterface"
    |
    */
    'expiration' => now()->addMinutes(60),

    /*
    |--------------------------------------------------------------------------
    | Upload/Download streaming
    |--------------------------------------------------------------------------
    |
    | Enable AWS S3 file upload & download streaming.
    | - offers significant performance advantages (memory use) over standard file uploading
    |
    | Supported: bool
    |
    */
    'streaming' => true,
];
