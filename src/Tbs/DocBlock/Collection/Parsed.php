<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Collection;

/**
 * object of encapsulation for parsed tag.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Parsed
{
    /**
     * @var string
     */
    protected $tag = null;

    /**
     * @var string
     */
    protected $type = null;

    /**
     * @var string
     */
    protected $content = null;

    /**
     * @var string
     */
    protected $description = null;

    /**
     * Set tag.
     *
     * @param  string $tag
     * @return \Tbs\DocBlock\Collection\Parsed
     */
    public function setTag($tag = null)
    {
        $this->tag = (string)$tag;
        return $this;
    }

    /**
     * Get tag.
     * @return string
     */
    public function getTag()
    {
        return (string)$this->tag;
    }

    /**
     * Set type.
     *
     * @param  string $type
     * @return \Tbs\DocBlock\Collection\Parsed
     */
    public function setType($type = null)
    {
        $this->type = (string)$type;
        return $this;
    }

    /**
     * Get type.
     * @return string
     */
    public function getType()
    {
        return (string)$this->type;
    }

    /**
     * Set content.
     *
     * @param  string $content
     * @return \Tbs\DocBlock\Collection\Parsed
     */
    public function setContent($content = null)
    {
        $this->content = (string)$content;
        return $this;
    }

    /**
     * Get content.
     * @return string
     */
    public function getContent()
    {
        return (string)$this->content;
    }

    /**
     * Set description.
     *
     * @param  string description
     * @return \Tbs\DocBlock\Collection\Parsed
     */
    public function setDescription($description = null)
    {
        $this->description = (string)$description;
        return $this;
    }

    /**
     * Get description.
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->description;
    }
}
