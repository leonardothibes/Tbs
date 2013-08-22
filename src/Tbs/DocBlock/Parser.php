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
     * Parse the doc block.
     *
     * @param  string $docBlock
     * @return array
     */
    public static function getParsed($docBlock)
    {
        $docBlock = self::cleanInput($docBlock);
        $docBlock = self::splitDocBlock($docBlock);
        return array(
            'shortDescription' => strlen($docBlock[0]) ? $docBlock[0] : null,
            'longDescription'  => strlen($docBlock[1]) ? $docBlock[1] : null,
            'tags'             => self::parseTags($docBlock['2']),
        );
    }

    /**
     * Strips the asterisks from the DocBlock comment.
     *
     * @link   <https://github.com/phpDocumentor/ReflectionDocBlock>
     * @param  string $docBlock
     * @return string
     */
    protected static function cleanInput($docBlock)
    {
        //Removing all asterisks.
        $docBlock = trim(
            preg_replace(
                '#[ \t]*(?:\/\*\*|\*\/|\*)?[ \t]{0,1}(.*)?#u',
                '$1',
                $docBlock
            )
        );

        //The regular expression above is not able to remove */ from a single line docblock.
        if (substr($docBlock, -2) == '*/') {
            $docBlock = trim(substr($docBlock, 0, -2));
        }

        //Normalizing strings.
        return str_replace(array("\r\n", "\r"), "\n", $docBlock);
    }

    /**
     * Splits the DocBlock into a short description, long description and
     * block of tags.
     *
     * @link   <https://github.com/phpDocumentor/ReflectionDocBlock>
     * @param  string $docBlock
     * @return array
     */
    protected static function splitDocBlock($docBlock)
    {
        if (strpos($docBlock, '@') === 0) {
            $matches = array('', '', $docBlock);
        } else {
            //Clears all extra horizontal whitespace from the line endings to prevent parsing issues.
            $docBlock = preg_replace('/\h*$/Sum', '', $docBlock);

            /**
             * Splits the docblock into a short description, long description and
             * tags section
             * - The short description is started from the first character until
             *   a dot is encountered followed by a newline OR
             *   two consecutive newlines (horizontal whitespace is taken into
             *   account to consider spacing errors)
             * - The long description, any character until a new line is
             *   encountered followed by an @ and word characters (a tag).
             *   This is optional.
             * - Tags; the remaining characters
             *
             * Big thanks to RichardJ for contributing this Regular Expression
             */
            preg_match(
                '/
                \A (
                  [^\n.]+
                  (?:
                    (?! \. \n | \n{2} ) # disallow the first seperator here
                    [\n.] (?! [ \t]* @\pL ) # disallow second seperator
                    [^\n.]+
                  )*
                  \.?
                )
                (?:
                  \s* # first seperator (actually newlines but it\'s all whitespace)
                  (?! @\pL ) # disallow the rest, to make sure this one doesn\'t match,
                  #if it doesn\'t exist
                  (
                    [^\n]+
                    (?: \n+
                      (?! [ \t]* @\pL ) # disallow second seperator (@param)
                      [^\n]+
                    )*
                  )
                )?
                (\s+ [\s\S]*)? # everything that follows
                /ux',
                $docBlock,
                $matches
            );
            array_shift($matches);
        }

        while (count($matches) < 3) {
            $matches[] = '';
        }
        return $matches;
    }

    /**
     * Creates the tag objects.
     *
     * @param  string $tags Tag block to parse.
     * @return array|null
     * @throws \Tbs\DocBlock\Exception
     */
    protected static function parseTags($tags = null)
    {
        if (!strlen($tags)) {
            return null;
        }

        $parsed = array();
        $tags   = trim($tags);

        if ($tags[0] !== '@') {
            throw new \Tbs\DocBlock\Exception(
                sprintf(
                    'A tag block started with text instead of an actual tag this makes the tag block invalid: %s',
                    $tags
                )
            );
        }

        foreach (explode("\n", $tags) as $i => $tag) {
            if (!strlen(trim($tag))) {
                unset($parsed[$i]);
                continue;
            }
            $parsedTag = self::parseTag($tag);
            $parsed[$parsedTag->getTag()][] = $parsedTag;
        }

        return $parsed;
    }

    /**
     * Parse the tag line.
     *
     * @param  string $tag_line
     * @return array
     * @throws \Tbs\DocBlock\Exception
     */
    protected static function parseTag($tag_line)
    {
        $tag = @explode(' ', $tag_line);
        if (!is_array($tag) or !isset($tag[0])) {
            $message = sprintf('Invalid tag line detected: %s', $tag_line);
            throw new \Tbs\DocBlock\Exception($message);
        }

        $className = ucfirst(strtolower(str_replace('@', '', $tag[0])));
        $tagClass  = sprintf('\\Tbs\\DocBlock\\Tag\\%sTag', $className);

        try {
            //Standard tags.
            $instance  = new $tagClass();
        } catch (\Tbs\Autoload\Exception $e) {
            //Custom tags.
            $instance  = new \Tbs\DocBlock\Tag\CustomTag();
        }

        return $instance->parse($tag_line);
    }
}
