<?php
/**
 * @package Tbs\Html
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Html;

/**
 * Describes HTML special chars.
 *
 * @package Tbs\Html
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class SpecialChars
{
    const TAB_DEFAUL         = "\11";
    const TAB_PSR            = "    ";
    const LINE_END_UNIX      = "\12";
    const LINE_END_MAC       = "\15";
    const LINE_END_WIN       = "\15\12";
    const HTML_COMMENT_OPEN  = "<!-- ";
    const HTML_COMMENT_CLOSE = " -->";
}
