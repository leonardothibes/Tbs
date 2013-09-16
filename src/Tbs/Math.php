<?php
/**
 * @package Tbs\Math
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;

/**
 * Math functions.
 *
 * @package Tbs\Math
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Math
{
    /**
     * Verify mod 10.
     *
     * @param  string $input
     * @return bool
     */
    public static function mod10($input)
    {
        $sum   = 0;
        $input = strrev($input);
        for ($i = 0; $i < strlen($input); $i++) {
            $current = substr($input, $i, 1);
            if ($i % 2 == 1) {
                $current *= 2;
                if ($current > 9) {
                    $firstDigit  = $current % 10;
                    $secondDigit = ($current - $firstDigit) / 10;
                    $current     = $firstDigit + $secondDigit;
                }
            }
            $sum += $current;
        }
        return ($sum % 10 == 0);
    }

    /**
     * Verify mod 11.
     *
     * @param  string $input
     * @return bool
     */
    public static function mod11($input)
    {
        return false;
    }
}
