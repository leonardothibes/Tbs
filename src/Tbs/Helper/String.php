<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

/**
 * String helper functions.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class String
{
     /**
     * Sanitize an string.
     *
     * @param string $string
     * @param string $tags   Allowed HTML tags("*" allow all).
     *
     * @return false|string
     */
    public static function sanitize($string, $tags = null)
    {
        $string = (string)$string;
        if (strlen($tags)) {
            if ($tags == '*') {
                $string = str_replace('--', '', $string);
                $string = addslashes($string);
            } else {
                $string = str_replace('--', '', $string);
                $string = addslashes($string);
                $string = strip_tags($string, $tags);
            }
            return $string;
        }

        $string = strip_tags($string, $tags);
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        $string = str_replace('--', '', $string);
        $string = addslashes($string);

        return $string;
    }

    /**
     * Concatenate strings with separator.
     *
     * @param string $string
     * @param string $value
     * @param string $separator
     */
    public static function concatenate(& $string, $value, $separator = ',')
    {
        if (strlen($string)) {
            $string .= "$separator ";
        }
        $string .= "$value";
    }

    /**
     * Add quotation marks in string.
     *
     * @param  string $string
     * @return string
     */
    public static function quotes($string = null)
    {
        return "'" . $string . "'";
    }

    /**
     * Add double quotation marks in string.
     *
     * @param  string $string
     * @return string
     */
    public static function doubleQuotes($string = null)
    {
        return '"' . $string . '"';
    }

    /**
     * Add a slash at the beginning of a string.
     *
     * @param  string $string
     * @return string
     */
    public static function firstSlash($string = null)
    {
        return (string)substr($string, 0, 1) != '/' ? '/' . $string : $string;
    }

    /**
     * Add a slash at the end of a string.
     *
     * @param  string $string
     * @return string
     */
    public static function lastSlash($string = null)
    {
        return (string)substr($string, -1) != '/' ? $string . '/' : $string;
    }

    /**
     * Truncate a string.
     *
     * @param string $string
     * @param int    $limit
     * @param string $char
     *
     * @return string
     */
    public static function truncate($string = null, $limit = 30, $char = '...')
    {
        if (strlen($string) < (int)$limit) {
            return $string;
        }
        $output = substr($string, 0, (int)$limit - 1);
        return $output . $char;
    }

    /**
     * Remove spaces from a string and converts to lowercase.
     *
     * @param  string $string
     * @return string
     */
    public static function lowerTrim($string = null)
    {
        return (string)strtolower(trim($string));
    }

    /**
     * Remove spaces from a string and converts to uppercase.
     *
     * @param  string $string
     * @return string
     */
    public static function upperTrim($string = null)
    {
        return (string)strtoupper(trim($string));
    }

    /**
     * Converts the first letter of a string uppercase.
     *
     * @param  string $string
     * @return string
     */
    public static function capitalize($string = null)
    {
        return ucfirst(strtolower((string)$string));
    }

    /**
     * Supersedes any number of slots in a string by a single space.
     *
     * @param  string $string
     * @return string
     */
    public static function oneSpaceOnly($string)
    {
        return (string)preg_replace('/\s\s+/', ' ', trim($string));
    }

    /**
     * Replace spaces with specified character.
     *
     * @param string $string
     * @param string $char
     *
     * @return string.
     */
    public static function stripSpaces($string, $char = '_')
    {
        return (string)str_replace(' ', $char, trim($string));
    }

    /**
     * Remove line breaks in a string.
     *
     * @param  string $string
     * @return string
     */
    public static function stripBreak($string)
    {
        return trim(preg_replace('/\n/', '', $string));
    }

    /**
     * Remove accents from a string.
     *
     * @param  string $string
     * @return string
     */
    public static function stripAccents($string)
    {
        return strtr(
            $string,
            array(

                /** Bloco do A **/
                'á' => 'a',
                'Á' => 'A',
                'à' => 'a',
                'À' => 'A',
                'â' => 'a',
                'Â' => 'A',
                'ã' => 'a',
                'Ã' => 'A',
                'ä' => 'a',
                'Ä' => 'A',
                /** Bloco do A **/

                /** Bloco do E **/
                'é' => 'e',
                'É' => 'E',
                'è' => 'e',
                'È' => 'E',
                'ê' => 'e',
                'Ê' => 'E',
                'ë' => 'e',
                'Ë' => 'E',
                /** Bloco do E **/

                /** Bloco do I **/
                'í' => 'i',
                'Í' => 'I',
                'ì' => 'i',
                'Ì' => 'I',
                'î' => 'i',
                'Î' => 'I',
                'ĩ' => 'i',
                'Ĩ' => 'I',
                'ï' => 'i',
                'Ï' => 'I',
                /** Bloco do I **/

                /** Bloco do O **/
                'ó' => 'o',
                'Ó' => 'O',
                'ò' => 'o',
                'Ò' => 'O',
                'ô' => 'o',
                'Ô' => 'O',
                'õ' => 'o',
                'Õ' => 'O',
                'ö' => 'o',
                'Ö' => 'O',
                /** Bloco do O **/

                /** Bloco do U **/
                'ú' => 'u',
                'Ú' => 'U',
                'ù' => 'u',
                'Ù' => 'U',
                'û' => 'u',
                'Û' => 'U',
                'ũ' => 'u',
                'Ũ' => 'U',
                'ü' => 'u',
                'Ü' => 'U',
                /** Bloco do U **/

                /** Bloco do Ç **/
                'ç' => 'c',
                'Ç' => 'C'
                /** Bloco do Ç **/
            )
        );
    }
}
