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
     * Get version number.
     *
     * @return string
     * @throws \Tbs\Version\Exception
     */
    public static function get()
    {
        $file = realpath(dirname(__FILE__) . '/Version/Number.txt');
        if (!file_exists($file)) {
            throw new \Tbs\Version\Exception(sprintf('File not found: %s', $file));
        }
        return file_get_contents($file);
    }
}
