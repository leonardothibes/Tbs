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
 * Methos of tags of @api tag.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ApiTag extends A
{
    /**
     * Parse the tag.
     *
     * @param  string $tag
     * @return array
     * @throws \Tbs\DocBlock\Tag\Exception
     */
    public function parse($tag)
    {
        if (!strlen($tag) or $tag != '@api') {
            $message = sprintf('Invalid api tag line detected: %s', $tag);
            throw new \Tbs\DocBlock\Tag\Exception($message);
        }
        return $this->parsed;
    }
}
