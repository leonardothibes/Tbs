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

/**
 * Abstract methods of tag recognition.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class Abstraction implements \Reflector, InterfaceTag
{
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
