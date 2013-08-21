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
class CustomTag extends A
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
        if (!strlen($tag) or substr($tag, 0, 1) != '@') {
            $message = sprintf('Invalid return tag line detected: %s', $tag);
            throw new \Tbs\DocBlock\Tag\Exception($message);
        }

        $tag = $this->splitTag($tag);
        $this->parsed->setTag($tag[0])
                     ->setContent($tag[1]);

        return $this->parsed;
    }
}
