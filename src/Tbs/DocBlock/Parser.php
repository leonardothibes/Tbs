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
            'shortDescription' => strlen($docBlock[0])   ? $docBlock[0] : null,
            'longDescription'  => strlen($docBlock[1])   ? $docBlock[1] : null,
            'tags'             => is_array($docBlock[2]) ? $docBlock[2] : array(),
        );
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
            // clears all extra horizontal whitespace from the line endings
            // to prevent parsing issues
            $docBlock = preg_replace('/\h*$/Sum', '', $docBlock);

            /*
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
}
