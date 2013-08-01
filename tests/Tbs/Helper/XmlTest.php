<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\Xml as xml;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class XmlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Xml
     */
    protected $object = null;

    /**
     * Setup.
     */
    public function setUp()
    {
    	$this->object = new xml;
    }

    /**
     * TearDown.
     */
    public function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Test if implements the right interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf('\Tbs\Helper\Interfaces\Validate', $this->object);
    }

    /**
     * Provider of valid XMLs.
     * @return array
     */
    public function providerValidXmls()
    {
        return array(
            array('<?xml version="1.0"?><root><row>val1</row></root>'),
            array('<root><row>val1</row></root>'),
            array('<?xml version="1.0"?><row>val1</row>'),
            array('<?xml version="1.0"?><root>val1</root>'),
        );
    }

    /**
     * @see \Tbs\Helper\Xml::isValid
     * @dataProvider providerValidXmls
     */
    public function testIsValid($xml)
    {
        $rs  = xml::isValid($xml);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid XMLs.
     * @return array
     */
    public function providerInvalidXmls()
    {
        return array(
            array(''),
            array(true),
            array(false),
            array(null),
            array(new \stdClass()),
            array(1),
            array('a'),
            array('<?xml version="1.0"?><root><row>val1</root>'),
            array('<?xml version="1.0"?><root>val1</row></root>'),
            array('<?xml version="2.0"?><root>val1</root>'),
            array('<?xml version="1.0.0"?><root>val1</root>'),
        );
    }

    /**
     * @see \Tbs\Helper\Xml::isValid
     * @dataProvider providerInvalidXmls
     */
    public function testIsInvalid($xml)
    {
        $rs = xml::isValid($xml);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Xml::sanitize
     * @dataProvider providerValidXmls
     */
    public function testSanitizeEquals($xml)
    {
        $rs = xml::sanitize($xml);
        $this->assertEquals($xml, $rs);
    }

    /**
     * Provider of valid XMLs with HTML tags.
     * @return array
     */
    public function providerValidXmlsWithHtmlTags()
    {
        return array(
            array('<?xml version="1.0"?><root><row>val1</row></root>'),
            array('<root><row>val1</row></root>'),
            array('<?xml version="1.0"?><row>val1</row>'),
            array('<?xml version="1.0"?><root>val1</root>'),
        );
    }

    /**
     * @see \Tbs\Helper\Xml::sanitize
     * @dataProvider providerValidXmls
     */
    public function testSanitizeTags($xml)
    {
        $rs = xml::sanitize($xml);
        $this->assertEquals($xml, $rs);
    }

    /**
     * Providers of XMLs to convert.
     * @return array
     */
    public function providerXmlsToConvert()
    {
        return array(
        	array(
        	    '<root><row1>val1</row1><row2>val2</row2><row3>val3</row3></root>',
        	    array('row1' => 'val1', 'row2' => 'val2', 'row3' => 'val3')
            ),
            array(
                '<root><row>val1</row><row>val2</row><row>val3</row></root>',
                array('row1' => 'val1', 'row2' => 'val2', 'row3' => 'val3')
            ),
        );
    }

    /**
     * @see \Tbs\Helper\Xml::toArray
     * @dataProvider providerXmlsToConvert
     */
    public function testToArray($xml, $expected)
    {
        $rs = xml::toArray($xml);
        $this->assertInternalType('array', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * @see \Tbs\Helper\Xml::toObject
     * @dataProvider providerXmlsToConvert
     */
    public function testToObject($xml)
    {
        $rs = xml::toObject($xml);
        $this->assertInstanceOf('stdClass', $rs);
        $this->assertEquals('val1', $rs->row1);
        $this->assertEquals('val2', $rs->row2);
        $this->assertEquals('val3', $rs->row3);
    }
}
