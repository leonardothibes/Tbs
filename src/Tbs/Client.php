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
    public static function getIp()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return '127.0.0.1';
        }
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Get client operating system.
     * @return string
     */
    public static function getOs()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return 'Console';
        }

        $SOs = array(
            'windows' => 'Windows',
            'linux'   => 'Linux',
            'macosx'  => 'MacOSX',
            'ios'     => 'iOS',
            'android' => 'Android'
        );

        foreach ($SOs as $so => $name) {
            $match = sprintf('/%s/i', $so);
            if (preg_match($match, $_SERVER['HTTP_USER_AGENT'])) {
                return (string)$name;
            }
        }

        return 'Unknown';
    }

    /**
     * Get client browser.
     * @return string
     */
    public static function getBrowser()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return 'Console';
        }

        $browsers = array(
            'firefox'   => 'Firefox',
            'Chrome'    => 'Google Chrome',
            'Opera'     => 'Opera',
            'netscape'  => 'Netscape',
            'msie'      => 'Microsoft Internet Explorer',
            'lynx'      => 'Lynx',
            'webtv'     => 'WebTV',
            'safari'    => 'Safari',
            'konqueror' => 'Konqueror',
            'bot'       => 'Web Crowler - Bot',
            'google'    => 'Web Crowler - Google',
            'scooter'   => 'Web Crowler - Scooter',
            'spider'    => 'Web Crowler - Spider',
            'slurp'     => 'Web Crowler - Slurp',
            'infoseek'  => 'Web Crowler - Infoseek',
        );

        foreach ($browsers as $browser => $name) {
            $match = sprintf('/%s/i', $browser);
            if (preg_match($match, $_SERVER['HTTP_USER_AGENT'])) {
                return (string)$name;
            }
        }

        return 'Unknown';
    }
}
