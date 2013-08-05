<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

use \Tbs\Helper\CreditCard\Master as Master;
use \Tbs\Helper\CreditCard\Visa   as Visa;
use \Tbs\Helper\CreditCard\Amex   as Amex;
use \Tbs\Helper\Interfaces        as V;

/**
 * Credit card helper functions for all flags.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class CreditCard implements V
{
    /**
     * Test if card number is valid.
     *
     * @param  string $card
     * @return bool
     */
    public static function isValid($card)
    {
        return (
            Master::isValid($card) or
            Visa::isValid($card)   or
            Amex::isValid($card)
        );
    }

    /**
     * Sanitize the card number .
     *
     * @param  string $card
     * @return string|false
    */
    public static function sanitize($card)
    {
        if (Master::isValid($card)) {
            return Master::sanitize($card);
        } elseif (Visa::isValid($card)) {
            return Visa::sanitize($card);
        } elseif (Amex::isValid($card)) {
            return Amex::sanitize($card);
        }
        return false;
    }
}
