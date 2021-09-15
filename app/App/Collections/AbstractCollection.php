<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

abstract class AbstractCollection extends Collection
{
    /**
     * Pluck a value from a Collection & sum its values.
     *
     *  - optionally replace a `0` value with a substitute
     *
     * @param  string  $value  value to pluck & sum
     * @param  bool  $zeroReplace  enable/disable zero replacement
     * @param  null  $replacement  zero replace substitute value
     * @return int|mixed|string
     */
    public function pluckSum(string $value, bool $zeroReplace = true, $replacement = null)
    {
        // Pluck & sum values
        $value = $this->pluck($value)->sum();

        // Replace `0` with $replacement if $zeroReplace is true
        return ($zeroReplace) ? zero_replace($value, $replacement) : $value;
    }
}
