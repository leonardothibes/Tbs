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
 * Credit card helper functions for Mastercard.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Master extends A
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
            substr($card, 0, 1) == 5 and
            parent::isValid($card)
        );
    }
}
