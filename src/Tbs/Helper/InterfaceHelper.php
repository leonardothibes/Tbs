<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
interface InterfaceHelper
{
    /**
     * Test if content is valid.
     *
     * @param  mixed $content
     * @return bool
     */
    public static function isValid($content);

    /**
     * Sanitize the content.
     *
     * @param  mixed $content
     * @return mixed
     */
    public static function sanitize($content);
}
