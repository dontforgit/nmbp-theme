<?php

/**
 * Debug function
 *
 * @param bool|array|object|string|null $vVariable
 *            Variable to be output to the screen
 * @param bool $bDie
 *            Should we halt execution?
 *
 * @return void Nothing is returned.
 */
function echo_pre($vVariable, $bDie = false)
{
    if (is_object($vVariable) || is_array($vVariable)) {
        echo "<pre>", print_r($vVariable), "</pre>";
    } else {
        var_dump($vVariable);
    }

    if ($bDie) {
        die;
    }
}