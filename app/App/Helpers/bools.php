<?php

/**
 * Determine if the $end is after (greater than) the start.
 *
 * @param $start
 * @param $end
 * @return bool
 */
function isEndAfterStart($start, $end): bool
{
    return ($end && $start) && ($end >= $start);
}
