<?php
/**
 * @package Tbs\DocBlock\Tag
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;

use \Tbs\DocBlock\Tag\Abstraction as A;

/**
 * Methos of tags of @return tag.
 *
 * @package Tbs\DocBlock\Tag
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
     * @throws \Tbs\DocBlock\Tag\Exception
     */
    public function parse($tag)
    {
        if (!strlen($tag) or substr($tag, 0, 7) != '@return') {
            $message = sprintf('Invalid return tag line detected: %s', $tag);
            throw new \Tbs\DocBlock\Tag\Exception($message);
        }

        $tag = $this->splitTag($tag);
        $this->parsed->setTag($tag[0])
             ->setType($tag[1]);

        if (isset($tag[2])) {
            unset($tag[0], $tag[1]);
            $this->parsed->setDescription(@implode(' ', $tag));
        }

        return $this->parsed;
    }
}
