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
     */
    public function __construct($docBlock = null)
    {
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
    public function hasSLongDescription()
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
        $tagName = strtolower(trim($tagName));
        return isset($this->tags[$tagName]);
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
            $message = sprintf('Tag has no exists: %s', $tagName);
            throw new \Tbs\DocBlock\Collection\Exception($message);
        }
        return $this->tags[$tagName];
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
        //Nothing to do... yet
    }

    /**
     * To string.
     *
     * @link   http://www.php.net/manual/en/reflector.tostring.php
     * @return string
     */
    public function __toString()
    {
        return self::export();
    }
}
