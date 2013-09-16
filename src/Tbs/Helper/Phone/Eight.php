<?php
/**
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\Phone;

use \Tbs\Helper\Interfaces\Mask     as M;
use \Tbs\Helper\Interfaces\Validate as V;

/**
 * Helper functions for phones of 8 digits.
 *
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Eight implements M, V
{
    /**
     * Test if phone is valid.
     *
     * @param  string $phone
     * @return bool
     */
    public static function isValid($phone)
    {
        return (bool)preg_match('/^\([0-9]{2}\)\s[0-9]{4}\-[0-9]{4}$/', $phone);
    }

    /**
     * Sanitize the phone.
     *
     * @param  string $phone
     * @return mixed
    */
    public static function sanitize($phone)
    {
        $sanitized = filter_var(strip_tags(self::unMask($phone)), FILTER_SANITIZE_NUMBER_INT);
        return self::mask($sanitized);
    }

    /**
     * Test if the phone is masked.
     *
     * @param  string $phone
     * @return bool
     */
    public static function isMasked($phone)
    {
        //Nothing to do.
        return self::isValid($phone);
    }

    /**
     * Mask the phone.
     *
     * @param  string $phone
     * @return string
    */
    public static function mask($phone)
    {
        return sprintf('(%d) %d-%d', substr($phone, 0, 2), substr($phone, 2, 4), substr($phone, 6, 4));
    }

    /**
     * Unmask the phone.
     *
     * @param  string $phone
     * @return string
    */
    public static function unMask($phone)
    {
        return str_replace(array('(', ')', '-', ' '), '', $phone);
    }

    /**
     * Unmask the phone and convert the result in array.
     *
     * @param  string $phone
     * @return string
     */
    public static function unMaskToArray($phone)
    {
        $phone = self::unMask($phone);
        return array(
            'ddd'   => substr($phone, 0, 2),
            'phone' => substr($phone, 2, 8),
        );
    }
}
