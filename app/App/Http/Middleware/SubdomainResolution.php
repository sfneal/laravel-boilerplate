<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SubdomainResolution
{
    /**
     * Remove the subdomain route parameter from the request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Remove route domain parameters
        if ($request->route()) {
            foreach (['subdomain', 'domain', 'tld'] as $param) {
                if ($request->route()->hasParameter($param)) {
                    $request->route()->forgetParameter($param);
                }
            }
        }

        // Set default URL
        URL::defaults([
            'domain' => $request->getHttpHost(),
        ]);

        return $next($request);
    }
}
