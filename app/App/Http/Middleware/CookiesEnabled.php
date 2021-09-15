<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cookie;

class CookiesEnabled
{
    public $cookies_enabled;

    public function __construct()
    {
        // Confirm that the users browser has cookies enabled
        Cookie::queue(Cookie::make('cookies_enabled', 1));
        $this->cookies_enabled = Cookie::get('cookies_enabled', 0);
    }
}
