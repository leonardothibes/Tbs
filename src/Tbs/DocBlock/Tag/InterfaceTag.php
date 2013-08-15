<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;

/**
 * Interface of tag parser classes.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
interface InterfaceTag
{
    /**
     * Parse the tag.
     *
     * @param  string $tag
     * @return array
     * @throws \Tbs\DocBlock\Tag\Exception
     */
    public function parse($tag);
}
