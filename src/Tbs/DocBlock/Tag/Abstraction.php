<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;

use \Tbs\DocBlock\Tag\InterfaceTag;
use \Tbs\DocBlock\Collection\Parsed;

/**
 * Abstract methods of tag recognition.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class Abstraction implements InterfaceTag
{
    /**
     * Parsed tag object.
     * @var \Tbs\DocBlock\Collection\Parsed
     */
    protected $parsed = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parsed = new Parsed;
    }

    /**
     * Split the tag parts.
     *
     * @param  string $tag
     * @return array
     */
    protected function splitTag($tag)
    {
        $splited = @explode(' ', preg_replace('/\s\s+/', ' ', trim($tag)));
        return $splited;
    }

    /**
     * Exports.
     *
     * @link   http://www.php.net/manual/en/reflector.export.php
     * @return string
     */
    public function export()
    {
        $tag = @implode(
            ' ',
            array(
                '@' . $this->parsed->getTag(),
                $this->parsed->getType(),
                $this->parsed->getContent(),
                $this->parsed->getDescription(),
            )
        );
        return preg_replace('/\s\s+/', ' ', trim($tag));
    }

    /**
     * To string.
     *
     * @link   http://www.php.net/manual/en/reflector.tostring.php
     * @return string
     */
    public function __toString()
    {
        return $this->export();
    }
}
