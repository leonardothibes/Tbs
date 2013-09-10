<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

use \Tbs\Helper\Interfaces\Validate as V;

/**
 * E-mail helper functions.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Email implements V
{
    /**
     * Test if e-mail is valid.
     *
     * @param string $email
     * @param bool   $domain
     *
     * @return bool
     */
    public static function isValid($email, $domain = false)
    {
        $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);
        if ($isValid and $domain) {
            return checkdnsrr($email);
        }
        return $isValid;
    }

    /**
     * Sanitize the e-mail.
     *
     * @param  string $email
     * @return string
     */
    public static function sanitize($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}
