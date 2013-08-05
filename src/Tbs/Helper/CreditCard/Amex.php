<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\CreditCard;

use \Tbs\Helper\CreditCard\AbstractCreditCard as A;

/**
 * Credit card helper functions for American Express.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Amex extends A
{
    /**
     * Credit card Amex regex.
     * @var string
     */
    protected static $regex = '/^[0-9]{5}\s[0-9]{6}\s[0-9]{4}$/';

    /**
     * Test if card number is valid.
     *
     * @param  string $card
     * @return bool
     */
    public static function isValid($card)
    {
        return (
            substr($card, 0, 1) == 3 and
            parent::isValid($card)
        );
    }

    /**
     * Mask the card number.
     *
     * @param  string $card
     * @return string
     */
    public static function mask($card)
    {
        return substr($data, 0, 5) . ' ' .
               substr($data, 5, 6) . ' ' .
               substr($data, 11, 4);
    }
}
