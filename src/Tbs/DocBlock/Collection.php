<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock;

use \Tbs\DocBlock\Parser;
use Tbs\DocBlock;

/**
 * The doc block collection of parserd tags class.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Collection implements \Reflector
{
    /**
     * Short description.
     * @var string
     */
    protected $shortDescription = null;

    /**
     * Long description.
     * @var string
     */
    protected $longDescription = null;

    /**
     * List of all tags.
     * @var array
     */
    protected $tags = array();

    /**
     * Constructor.
     *
     * @param  string $docBlock
     * @return void
     * @throws \Tbs\DocBlock\Collection\Exception
     */
    public function __construct($docBlock)
    {
        if(!strlen($docBlock)) {
            $message = 'DocBlock cannot be blank.';
            throw new \Tbs\DocBlock\Collection\Exception($message);
        }
        $parsed = Parser::getParsed($docBlock);
        $this->shortDescription = $parsed['shortDescription'];
        $this->longDescription  = $parsed['longDescription'];
        $this->tags             = $parsed['tags'];
    }

    /**
     * Test if has short description.
     * @return bool
     */
    public function hasShortDescription()
    {
        return (bool)strlen($this->shortDescription);
    }

    /**
     * Get short description.
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Test if has long description.
     * @return bool
     */
    public function hasLongDescription()
    {
        return (bool)strlen($this->longDescription);
    }

    /**
     * Get long description.
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * Get short and long description combined.
     * @return string
     */
    public function getText()
    {
        if(!strlen($this->shortDescription) or !strlen($this->longDescription)) {
            return null;
        }
        return $this->shortDescription . "\n\n" .
               $this->longDescription;
    }

    /**
     * Test if has tag.
     *
     * @param  string $tagName
     * @return bool
     */
    public function hasTag($tagName)
    {
        return isset($this->tags[trim($tagName)]);
    }

    /**
     * Get a tag value.
     *
     * @param  string $tagName
     * @return array
     * @throws \Tbs\DocBlock\Collection\Exception
     */
    public function getTag($tagName)
    {
        if (!$this->hasTag($tagName)) {
            $message = sprintf('Tag is not available: %s', $tagName);
            throw new \Tbs\DocBlock\Collection\Exception($message);
        }
        return $this->tags[trim($tagName)];
    }

    /**
     * Test if has tags.
     * @return bool
     */
    public function hasTags()
    {
        return (count($this->tags) > 0);
    }

    /**
     * Get all tags.
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Exports.
     *
     * @link   http://www.php.net/manual/en/reflector.export.php
     * @return string
     */
    public static function export()
    {

    }

    /**
     * To string.
     *
     * @link   http://www.php.net/manual/en/reflector.tostring.php
     * @return string
     */
    public function __toString()
    {
        $content  = null;
        $docBlock = <<<DOCBLOCK
/**
 * {{CONTENT}}
 */
DOCBLOCK;

        if ($this->hasShortDescription()) {
            $content .= $this->getShortDescription();
        }

        if ($this->hasLongDescription()) {
            $content .= "\n *\n * " . $this->getLongDescription();
        }

        if ($this->hasTags()) {
            $content .= "\n * ";
            foreach ($this->getTags() as $tagName => $tags) {
                 foreach ($tags as $tag) {
                    $content .= "\n * " . $tag->export();
                }
            }
        }

        return str_replace('{{CONTENT}}', $content, $docBlock);
    }
}
