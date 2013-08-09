<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock;

/**
 * DocBlock abstraction class.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlobk
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Parser
{
    /**
     * Parsed DocBlock.
     * @var array
     */
    protected static $parsed = array(
        'shortDescription' => null,
        'longDescription'  => null,
        'tags'             => array(),
    );
    /**
     * Parse the doc block.
     *
     * @param  string $docBlock
     * @return array
     */
    public static function getParsed($docBlock)
    {
        return self::$parsed;
    }
}
