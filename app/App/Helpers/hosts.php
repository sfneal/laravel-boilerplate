<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

/**
 * Retrieve the MarketingImage API host.
 *
 * @return mixed
 */
function apiMarketingimgHost()
{
    // Cache results set if not already cached
    return Cache::rememberForever('app:api:marketingimg:host', function () {
        return env('IMG_API_HOST').':'.env('IMG_API_PORT');
    });
}

/**
 * Retrieve the Pdfconduit API host.
 *
 * @return mixed
 */
function apiPdfconduitHost()
{
    // Cache results set if not already cached
    return Cache::rememberForever('app:api:pdfconduit:host', function () {
        return env('PDF_API_HOST').':'.env('PDF_API_PORT');
    });
}

/**
 * Retrieve the Pdfconduit API version.
 *
 * @return mixed
 */
function apiPdfconduitVersion()
{
    // Cache results set if not already cached
    return Cache::rememberForever('app:api:pdfconduit:version', function () {
        try {
            $response = (new Client())->request('get', apiPdfconduitHost().'/api/pdfconduit/test');
            $version = json_decode((string) $response->getBody()->getContents(), true)['version'];
            $version = '<i class="fa fa-github-square"></i> '.'v'.$version;
        } catch (GuzzleException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            $version = 'N/A';
        }

        return $version;
    });
}

/**
 * Retrieve a Public Site URL.
 *
 * @param  string  $path
 * @return string
 */
function publicSiteUrl(string $path = ''): string
{
    // Cache key
    $key = 'app:sites:public:url';

    // Get the base url
    $url = Cache::rememberForever($key, function () {
        return '//'.(env('APP_PUBLIC_SUBDOMAIN') ? env('APP_PUBLIC_SUBDOMAIN').'.' : '').env('APP_DOMAIN');
    });

    // Return the $url if no path was provided
    if (strlen($path) < 1) {
        return $url;
    }

    // Cache results set if not already cached
    return Cache::rememberForever($key."#{$path}", function () use ($path, $url) {
        return $url.'/'.trim($path, '/');
    });
}

/**
 * Retrieve a Public Site URL.
 *
 * @param  string  $path
 * @return string
 */
function portalSiteUrl(string $path = ''): string
{
    // Cache key
    $key = 'app:sites:portal:url';

    // Get the base url
    $url = Cache::rememberForever($key, function () {
        return '//'.env('APP_PORTAL_SUBDOMAIN').'.'.env('APP_DOMAIN');
    });

    // Return the $url if no path was provided
    if (strlen($path) < 1) {
        return $url;
    }

    // Cache results set if not already cached
    return Cache::rememberForever($key."#{$path}", function () use ($path, $url) {
        return $url.'/'.trim($path, '/');
    });
}

/**
 * Retrieve a portal URL for the stable version.
 *
 * @param  string  $path
 * @return string
 */
function stablePortalSiteUrl(string $path = ''): string
{
    // Cache key
    $key = 'app:sites:portal-stable:url';

    // Get the base url
    $url = Cache::rememberForever($key, function () {
        return '//'.env('APP_STABLE_SUBDOMAIN').'.'.env('APP_PORTAL_SUBDOMAIN').'.'.env('APP_DOMAIN');
    });

    // Return the $url if no path was provided
    if (strlen($path) < 1) {
        return $url;
    }

    // Cache results set if not already cached
    return Cache::rememberForever($key."#{$path}", function () use ($path, $url) {
        return $url.'/'.trim($path, '/');
    });
}

/**
 * Retrieve a Legacy Site URL.
 *
 * @param  string  $path
 * @return mixed
 */
function legacySiteUrl($path = '')
{
    // Cache results set if not already cached
    return Cache::rememberForever('app:sites:legacy:url'.((strlen($path) > 1) ? "s#{$path}" : ''),
        function () use ($path) {
            return 'http://'.env('LEGACY_SITE_URL').'/'.trim($path, '/');
        }
    );
}
