<?php

use Sfneal\Helpers\Aws\S3\StorageS3;

/**
 * Return a 'check' or 'x' icon depending on input value.
 *
 * @param $val
 * @param  int  $red_val
 * @return string
 */
function boolIcon($val, $red_val = 1)
{
    if ($val == $red_val) {
        $style = 'red';
        $icon = 'fa fa-times-circle';
    } else {
        $style = 'green';
        $icon = 'fa fa-check-circle';
    }

    return '<i class="'.$icon.'" style="color: '.$style.'"></i>';
}

/**
 * Return a bool icon with a truthy value being green.
 *
 * @param $val
 * @param  int  $green_val
 * @return string
 */
function boolIconGreen($val, $green_val = 1)
{
    if ($val == $green_val) {
        $style = 'green';
        $icon = 'fa fa-check-circle';
    } else {
        $style = 'red';
        $icon = 'fa fa-times-circle';
    }

    return '<i class="'.$icon.'" style="color: '.$style.'"></i>';
}

/**
 * Determine if a nav item is the active menu.
 *
 * @param $nav_item
 * @param $menu_active
 * @return string
 */
function activeMenu($nav_item, $menu_active)
{
    if (isset($menu_active) && $menu_active == $nav_item) {
        return 'active';
    } else {
        return '';
    }
}

/**
 * Retrieve the 'active' navbar logo for when the 'home' page is the active page.
 *
 * @param $nav_item
 * @param $menu_active
 * @param $path
 * @return string
 */
function activeMenuLogo($nav_item, $menu_active, $path)
{
    if (isset($menu_active) && $menu_active == $nav_item) {
        return imgPath(getImageFile($path, 'active', false));
    } else {
        return imgPath(getImageFile($path, '', false));
    }
}

/**
 * Return a 'Learn More' button to be used in the public site.
 *
 * @param $route
 * @param  null  $msg
 * @param  string  $title
 * @return string
 */
function learnMoreBtnRow($route, $msg = null, $title = 'Learn More')
{
    $r = route($route);
    $response = '<div class="row">';
    $response .= '<div class="col-md-5 mx-auto g-mt-40">';
    $response .= '<div class="text-center">';
    $response .= "<a href='$r' class='btn btn-block btn-xl u-btn-primary u-btn-content g-letter-spacing-0_5 text-uppercase g-mr-10 g-mb-15'>";
    $response .= $title;
    $response .= (isset($msg) ? "<span class='d-block g-font-size-11'>$msg</span>" : '');
    $response .= '</a>';
    $response .= '</div>';
    $response .= '</div>';
    $response .= '</div>';

    return $response;
}

/**
 * Retrieve the page's title with a default value.
 *
 * @param  string|null  $title
 * @param  bool  $suffix
 * @return string
 */
function pageTitle(string $title = null, bool $suffix = true): string
{
    if (isset($title) && $suffix) {
        return $title.' - '.config('app.name');
    } elseif (isset($title) && ! $suffix) {
        return $title;
    } else {
        return config('app.name');
    }
}

/**
 * Retrieve the page's description with a default value.
 *
 * @param  string|null  $desc
 * @return string
 */
function pageDesc(string $desc = null)
{
    $default = 'Tired of ordering house plans and getting blueprint sets that lack the completeness ';
    $default .= 'required to build accurately, practically, and most importantly, cost-effectively? ';
    $default .= 'Our house plans are buildable! Unlike many of the other house plan sites out there, ';
    $default .= 'all of the house plans found on hpadesign.com have been built. HPA Design is not a ';
    $default .= 'plan boutique that designs homes solely with the intention of selling the plan. ';
    $default .= 'We are a licensed architectural practice and all of our plans have been custom designed ';
    $default .= 'for specific clients. Selling such custom home designs after the fact is simply a means ';
    $default .= 'for us to deliver the tremendous value of innovative designs combined with high quality ';
    $default .= 'construction drawings to home owners, builders, and developers at a significantly reduced ';
    $default .= 'cost. So, get house plans that you can build from...Browse our site, find the house plan ';
    $default .= "that's right for you, &amp; buy it right online.";

    return $desc ?? $default;
}

/**
 * Retrieve the page's image with a default.
 *
 * @param  string|null  $img
 * @return string
 */
function pageImg(string $img = null)
{
    return $img ?? StorageS3::key('img/about/20020443_existing_101.jpg')->urlTemp();
}

/**
 * Retrieve the slicey revolution slider's overlay opacity.
 *
 * @param $slide
 * @return float
 */
function slicey_slider_overlay_opacity($slide)
{
    if (isset($slide['title']) && ! empty($slide['title'])) {
        if (isset($slide['text']) && ! empty($slide['text'])) {
            if (isset($slide['link']) && ! empty($slide['link'])) {
                return 0.3;
            }
        }
    }

    return 0.0;
}
