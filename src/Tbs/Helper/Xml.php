<?php
/**
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

use \Tbs\Helper\Interfaces\Validate as V;

/**
 * Class_Description
 *
 * @package Tbs\Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Xml implements V
{
    /**
     * Test if XML is valid.
     *
     * @param  string $xml
     * @return bool
     */
    public static function isValid($xml)
    {
        $xml = @simplexml_load_string($xml);
        return ($xml instanceof \SimpleXMLElement);
    }

    /**
     * Sanitize the XML.
     *
     * @param  string $xml
     * @return string
    */
    public static function sanitize($xml)
    {
        //Nothing to do.
        return $xml;
    }

    /**
     * Convert XML to array.
     *
     * @param  string $xml
     * @return array
     */
    public static function toArray($xml)
    {
        $xml = @simplexml_load_string($xml);
        $new = array();
        $idx = (int)0;
        foreach ($xml as $key => $value) {
            $key = ($key == 'row') ? $key . ++$idx : $key;
            $new[$key] = trim($value);
        }

        return $new;
    }

    /**
     * Convert XML to stdClass object.
     *
     * @param  array $array
     * @return \stdClass
     */
    public static function toObject($xml)
    {
        $xml = @simplexml_load_string($xml);
        $obj = new \stdClass();
        $idx = (int)0;
        foreach ($xml as $key => $value) {
            $key = trim($key);
            $key = ($key == 'row') ? $key . ++$idx : $key;
            $obj->{$key} = trim($value);
        }
        return $obj;
    }
}
