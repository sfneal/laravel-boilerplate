<?php

// todo: consider refactor to sfneal/laravel-helpers

/**
 * Determine if a $value matches a request key.
 *
 * @param $key
 * @param $value
 * @param  string  $selected
 * @return string
 */
function filterSelected($key, $value, $selected = 'selected')
{
    $request = request($key);
    if (! is_array($request)) {
        return ($request == $value) ? $selected : '';
    } else {
        return (in_array($value, $request)) ? $selected : '';
    }
}

/**
 * Determine if a form in put is checked.
 *
 * @param $key
 * @param  int  $value
 * @return string
 */
function filterChecked($key, $value = 1)
{
    return filterSelected($key, $value, 'checked');
}
