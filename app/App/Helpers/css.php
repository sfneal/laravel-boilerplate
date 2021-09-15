<?php

/**
 * Return a best fit bootstrap column size.
 *
 * @param  array  $array
 * @return int column_size
 */
function bootstrapColumnSizer(array $array)
{
    // Divide 12 by the size of the array (columns)
    return intdiv(12, count($array));
}

/**
 * Retrieve the plan results view button class.
 *
 * @param $btn
 * @param $view
 * @return string
 */
function getPlanResultsViewButtonClass($btn, $view)
{
    $class = 'btn';
    if ($view == $btn) {
        $class .= ' g-color-primary';
    } else {
        $class .= ' g-color-gray-dark-v2';
    }

    return $class;
}
