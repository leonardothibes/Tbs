<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;

use \Tbs\DocBlock\Tag\Abstraction as A;

/**
 * Abstract methos of tags of DocBlock.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ReturnTag extends A
{
    /**
     * Parse the tag.
     *
     * @param  string $tag
     * @return array
     */
    public static function parse($tag)
    {
        return 'parsed return';
    }
}
