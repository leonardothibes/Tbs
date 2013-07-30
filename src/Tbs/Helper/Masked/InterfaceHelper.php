<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\Masked;

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
     * Test if the content is masked.
     *
     * @param  mixed $content
     * @return bool
     */
    public static function isMasked($content);

    /**
     * Mask the content.
     *
     * @param  mixed $content
     * @return mixed
     */
    public static function mask($content);

    /**
     * Unmask the content.
     *
     * @param  mixed $content
     * @return mixed
     */
    public static function unMask($content);
}
