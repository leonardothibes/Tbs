<?php
/**
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

/**
 * Money helper functions.
 *
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Money
{
    /**
     * Possible money formats.
     */
    const DOLAR = 'D';
    const EURO  = 'E';
    const REAL  = 'R';

    /**
     * Convert money to number format.
     *
     * @param float  $value
     * @param string $format
     *
     * @return float|false
     */
    public static function toNumber($value, $format = self::REAL)
    {
        switch ($format) {
            case self::REAL:
            case self::EURO:
                $value = str_replace('.', '', $value);
                $value = str_replace(',', '.', $value);
                break;
            case self::DOLAR:
                $value = str_replace(',', '', $value);
                break;
            default:
                return false;
        }
        return (float)number_format($value, 2, '.', '');
    }
}
