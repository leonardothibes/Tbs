<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\Interfaces;

/**
 * Interface of helpers who implements mask functions.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
interface Mask
{
    /**
     * Test if the content is masked.
     *
     * @param  string $content
     * @return bool
     */
    public static function isMasked($content);

    /**
     * Mask the content.
     *
     * @param  string $content
     * @return string
     */
    public static function mask($content);

    /**
     * Unmask the content.
     *
     * @param  string $content
     * @return string
     */
    public static function unMask($content);
}
