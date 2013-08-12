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
 * Abstract methods of tag recognition.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class Abstraction implements \Reflector
{
    /**
     * Tag name(@param, @return, @author...).
     * @var string
     */
    protected $tagName = null;

    /**
     * Tag Type(string, int, array...).
     * @var string
     */
    protected $tagType = null;

    /**
     * Tag content.
     * @var string
     */
    protected $tagContent = null;

    /**
     * Tag content.
     * @var string
     */
    protected $tagDescription = null;

    /**
     * Set the tag name.
     *
     * @param  string $tagName
     * @return \Tbs\DocBlock\Tag\Abstraction
     */
    public function setTagName($tagName)
    {
        $this->tagName = (string)$tagName;
        return $this;
    }

    /**
     * Get the tag name.
     * @return string
     */
    public function getTagName()
    {
        return (string)$this->tagName;
    }
}
