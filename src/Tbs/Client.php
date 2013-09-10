<?php
/**
 * @package Tbs\Client
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;

/**
 * Client Machine Information.
 *
 * @package \Tbs\Client
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Client
{
    /**
     * Get client IP.
     * @return string
     */
    static public function getIp()
    {
        if(!isset($_SERVER['HTTP_USER_AGENT'])) {
            return '127.0.0.1';
        }
        return $_SERVER['REMOTE_ADDR'];
    }
}
