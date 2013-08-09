<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Version
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;

/**
 * Version information class.
 *
 * @category Library
 * @package Tbs
 * @subpackage Version
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Version
{
    /**
     * Get default location of version number file.
     * @return string
     */
    public static function getDefaultFileLocation()
    {
        return realpath(dirname(__FILE__) . '/Version/Number.txt');
    }

    /**
     * Get version number.
     *
     * @param  string $fileLocation
     * @return string
     * @throws \Tbs\Version\Exception
     */
    public static function get($fileLocation = null)
    {
        $file = strlen($fileLocation) ? $fileLocation : self::getDefaultFileLocation();
        if (!file_exists($file)) {
            $message = sprintf('File not found: %s', $file);
            throw new \Tbs\Version\Exception($message);
        }

        return trim(file_get_contents($file), '\t\n\r');
    }
}
