<?php
/**
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\CreditCard;

use \Tbs\Helper\CreditCard\AbstractCreditCard as A;

/**
 * Credit card helper functions for Visa.
 *
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Visa extends A
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
            substr($card, 0, 1) == 4 and
            parent::isValid($card)
        );
    }
}
