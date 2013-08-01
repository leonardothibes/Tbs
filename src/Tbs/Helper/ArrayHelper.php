<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

use \Tbs\Helper\Interfaces\Validate as V;

/**
 * Array helper functions.
 *
 * @category Library
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ArrayHelper implements V
{
    /**
     * Test if Array is valid.
     *
     * @param  array $array
     * @return bool
     */
    public static function isValid($array)
    {
        return (is_array($array) and count($array) > 0);
    }

    /**
     * Sanitize the Array.
     *
     * @param  array $array
     * @return array
     */
    public static function sanitize($array)
    {
        return array_map('\Tbs\Helper\String::sanitize', $array);
    }

    /**
     * Add quotation marks in string.
     *
     * @param  array $array
     * @return array
     */
    public static function quotes($array)
    {
        return array_map('\Tbs\Helper\String::quotes', $array);
    }

    /**
     * Convert array to parameter list.
     *
     * @param  array $array
     * @return string
     */
    public static function toParamList($array)
    {
        return @implode(',', self::quotes($array));
    }

    /**
     * Convert array to XML.
     *
     * @param array $array      $array to convert.
     * @param string            $root  Root node name.
     * @param \SimpleXMLElement $xml   Object for recursivity.
     *
     * @return string
     */
    public static function toXml($array, $root = 'root', $xml = null)
    {
        if (is_null($xml)) {
            $root = sprintf('<%s />', $root);
            $xml  = new SimpleXmlElement($root);
        }

        foreach ($array as $key => $value) {

            $key = is_numeric($key) ? 'row' : $key;
            $key = preg_replace('/[^a-z]/i', '', $key);

            if (is_array($value)) {
                $node = $xml->addChild($key);
                self::toXml($value, $root, $node);
            } else {
                $xml->addChild(strtolower($key), $value);
            }
        }

        return $xml->asXML();
    }

    /**
     * Convert array to stdClass object.
     *
     * @param  array $array
     * @return \stdClass
     */
    public static function toObject($array)
    {
        $obj = new $object();
        foreach ($array as $key => $value) {
            $key = trim($key);
            $obj->{$key} = self::toObject($value);
        }
        return $obj;
    }

    /**
     * Remove empty indexes of array.
     *
     * @param  array $array
     * @return array
     */
    public static function removeEmpty($array)
    {
        foreach ($array as $i => $val) {
            if (!strlen($val)) {
                unset($array[$i]);
            }
        }
        return $array;
    }

    /**
     * Search in array.
     *
     * @param array  $array   Array for search.
     * @param string $search  String for search.
     * @param bool   $use_key Concatenate.
     * @param string $sep	  Separator.
     *
     * @return string
     */
    public static function search($array, $search, $use_key = true, $sep = ',')
    {
        $result = null;
        foreach ($array as $key => $value) {
            if (strpos(strtolower($value), $search) !== false) {
                if ($use_key) {
                    $result .= $key . $sep . $value . "\n";
                } else {
                    $result .= $value . "\n";
                }
            }
        }
        return $result;
    }

    /**
     * Sort an array.
     *
     * @param array   $array
     * @param string  $column
     * @param boolean $reverse
     *
     * @return array
     */
    public static function sort($array, $column, $revser = false)
    {
        for ($i = 0; $i < count($array) - 1; $i++) {
            for ($j = 0; $j < count($array) - 1 - $i; $j++) {
                if ($array[$j][$column] > $array[$j+1][$column]) {
                    $tmp         = $array[$j];
                    $array[$j]   = $array[$j+1];
                    $array[$j+1] = $tmp;
                }
            }
        }
        return $reverse ? array_reverse($array) : $array;
    }
}
