<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

/**
 * Number helper functions.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Number
{
    /**
     * Possible money formats.
     */
    const DOLAR = 'D';
    const EURO  = 'E';
    const REAL  = 'R';

    /**
     * Convert number to money format.
     *
     * @param float  $number
     * @param string $format
     *
     * @return string|false
     */
    public static function toMoney($number, $format = self::REAL)
    {
        switch ($format) {
            case self::REAL:
            case self::EURO:
                return number_format($number, 2, ',', '.');
                break;
            case self::DOLAR:
                return number_format($number, 2, '.', ',');
                break;
        }
        return false;
    }
}
