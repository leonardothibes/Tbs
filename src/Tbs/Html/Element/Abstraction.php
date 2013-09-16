<?php
/**
 * @package Tbs\Html\Element
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Html\Element;

use \Tbs\Html\Interfaces\Renderable;
use \Tbs\Html\SpecialChars;

/**
 * Abstract methods for HTML element classes.
 *
 * @package Tbs\Html\Element
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class Abstraction implements Renderable
{
    /**
     * HTML rendered string.
     * @var string
     */
    protected $html = null;

    /**
     * Attributes of element.
     * @var array
     */
    protected $attributes = array();

    /**
     * Tab string.
     * @var string
     */
    protected $tab = SpecialChars::TAB_DEFAUL;

    /**
     * Line end string.
     * @var String
     */
    protected $lineEnd = SpecialChars::LINE_END_UNIX;

    /**
     * Top comment of element.
     * @var string
     */
    protected $topComment = null;

    /**
     * Bottom comment of element.
     * @var string
     */
    protected $bottomComment = null;

    /**
     * Set the attributes array.
     *
     * @param  array $attributes
     * @return \Tbs\Html\Element\Abstraction
     */
    public function setAttributes(array $attributes = array())
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Get the attributes array.
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Add attribute in element.
     *
     * @param string $attribute
     * @param string $value
     *
     * @return \Tbs\Html\Element\Abstraction
     */
    public function addAttribute($attribute, $value = null)
    {
        $this->attributes[(string)$attribute] = (string)$value;
        return $this;
    }

    /**
     * Remove attribute from element.
     *
     * @param  string $attribute
     * @return \Tbs\Html\Element\Abstraction
     */
    public function removeAttribute($attribute)
    {
        unset($this->attributes[(string)$attribute]);
        return $this;
    }

    /**
     * Get attribute value.
     *
     * @param  string $attribute
     * @return string
     */
    public function getAttribute($attribute)
    {
        return $this->attributes[(string)$attribute];
    }

    /**
     * Set tab string to ident the element.
     *
     * @param  string $tab
     * @return \Tbs\Html\Element\Abstraction
     */
    public function setTab($tab = SpecialChars::TAB_DEFAUL)
    {
        $this->tab = (string)$tab;
        return $this;
    }

    /**
     * Get tab string.
     * @return string
     */
    public function getTab()
    {
        return (string)$this->tab;
    }

    /**
     * Set the line end string.
     *
     * @param  string $lineEnd
     * @return \Tbs\Html\Element\Abstraction
     */
    public function setLineEnd($lineEnd = SpecialChars::LINE_END_UNIX)
    {
        $this->lineEnd = (string)$lineEnd;
        return $this;
    }

    /**
     * Get the line end string.
     * @return string
     */
    public function getLineEnd()
    {
        return (string)$this->lineEnd;
    }

    /**
     * Clean the comments of special chars.
     *
     * @param  string $comment
     * @return stirng
     */
    protected function cleanComments($comment = null)
    {
        $chars = array(
            SpecialChars::HTML_COMMENT_OPEN,
            SpecialChars::HTML_COMMENT_OPEN . ' ',
            SpecialChars::HTML_COMMENT_CLOSE,
            ' ' . SpecialChars::HTML_COMMENT_CLOSE,
        );
        return str_replace($chars, '', $comment);
    }

    /**
     * Set the top comment in element.
     *
     * @param  string $topComment
     * @return \Tbs\Html\Element\Abstraction
     */
    public function setTopComment($topComment = null)
    {
        $this->topComment = $this->cleanComments((string)$topComment);
        return $this;
    }

    /**
     * Get the top comment from element.
     * @return string
     */
    public function getTopComment()
    {
        return (string)$this->topComment;
    }

    /**
     * Set the bottom comment in element.
     *
     * @param  string $bottomComment
     * @return \Tbs\Html\Element\Abstraction
     */
    public function setBottomComment($bottomComment = null)
    {
        $this->bottomComment = (string)$bottomComment;
        return $this;
    }

    /**
     * Get the bottom comment from element.
     * @return string
     */
    public function getBottomComment()
    {
        return (string)$this->bottomComment;
    }

    /**
     * Render HTML of element.
     * @return string
     */
    public function render()
    {
        return $this->html;
    }

    /**
     * Target to $this->render method.
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
