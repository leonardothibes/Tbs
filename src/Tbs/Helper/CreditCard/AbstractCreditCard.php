<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\CreditCard;

use \Tbs\Helper\Interfaces\Mask     as M;
use \Tbs\Helper\Interfaces\Validate as V;

/**
 * Credit card helper functions for all flags.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class AbstractCreditCard implements M, V
{
    /**
     * Credit card regex.
     * @var string
     */
    protected static $regex = '/^[0-9]{4}\s[0-9]{4}\s[0-9]{4}\s[0-9]{4}$/';

    /**
     * Test if card number is valid.
     *
     * @param  string $card
     * @return bool
     */
    public static function isValid($card)
    {
        $card = preg_replace('([^0-9])', '', $card);
        if (!empty($card)) {
            return \Tbs\Math::mod10($card);
        }
        return false;
    }

    /**
     * Sanitize the card number.
     *
     * @param  string $card
     * @return mixed
    */
    public static function sanitize($card)
    {
        $sanitized = filter_var(strip_tags(self::unMask($card)), FILTER_SANITIZE_NUMBER_INT);
        return self::mask($sanitized);
    }

    /**
     * Test if the card number is masked.
     *
     * @param  string $card
     * @return bool
     */
    public static function isMasked($card)
    {
        return (bool)preg_match(self::$regex, $card);
    }

    /**
     * Mask the card number.
     *
     * @param  string $card
     * @return string
    */
    public static function mask($card)
    {
        return substr($data, 0, 4)  . ' ' .
               substr($data, 4, 4)  . ' ' .
               substr($data, 8, 4)  . ' ' .
               substr($data, 12, 4);
    }

    /**
     * Unmask the card number.
     *
     * @param  string $card
     * @return string
    */
    public static function unMask($card)
    {
        return str_replace(' ', '', $data);
    }
}
