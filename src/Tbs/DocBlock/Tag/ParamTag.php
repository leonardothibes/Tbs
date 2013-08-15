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
class ParamTag extends A
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
        if(!strlen($tag) or substr($tag, 0, 6) != '@param') {
            $message = sprintf('Invalid param tag line detected: %s', $tag);
            throw new \Tbs\DocBlock\Tag\Exception($message);
        }

        $tag = $this->splitTag($tag);
        $ret = array(
        	'tag'     => 'param',
            'type'    => $tag[1],
            'content' => $tag[2],
        );

        if(isset($tag[3])) {
            unset($tag[1], $tag[2]);
            $ret['description'] = @implode(' ', $tag);
        }

        return $ret;
    }
}
