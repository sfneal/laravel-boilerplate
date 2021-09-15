<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookiesAccepted extends CookiesEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cookies_accepted = Cookie::get('cookies_accepted', 0);
        if ($cookies_accepted != 1) {
            // Flash update alert on next page load
            $request->session()->flash('cookie-policy', $cookies_accepted);
        } else {
            session()->forget('cookie-policy');
        }

        if ($this->cookies_enabled != 1) {
            $request->session()->flash('cookie-disabled-warning', $this->cookies_enabled);
        } else {
            session()->forget('cookie-disabled-warning');
        }

        return $next($request);
    }
}
