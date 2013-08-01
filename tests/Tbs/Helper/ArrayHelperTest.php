<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\ArrayHelper as arr;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ArrayHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\ArrayHelper
     */
    protected $object = null;

    /**
     * Setup.
     */
    public function setUp()
    {
    	$this->object = new arr;
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
     * Provider of valid arrays.
     * @return array
     */
    public function providerValidArrays()
    {
        return array(
            array(array(0,1,2,3,4,5,6,7,8,9)),
            array(array('a', 'e', 'i', 'o', 'u')),
            array(array(0, 'a', 1, 'e', 2, '3', 'i'))
        );
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::isValid
     * @dataProvider providerValidArrays
     */
    public function testIsValid($array)
    {
        $rs = arr::isValid($array);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid arrays.
     * @return array
     */
    public function providerInvalidArrays()
    {
        return array(
            array(array()),
            array(true),
            array(false),
            array('abc'),
            array(123),
            array(new \stdClass())
        );
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::isValid
     * @dataProvider providerInvalidArrays
     */
    public function testIsInvalid($array)
    {
        $rs = arr::isValid($array);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::sanitize
     * @dataProvider providerValidArrays
     */
    public function testSanitizeEquals($array)
    {
        $rs = arr::sanitize($array);
        $this->assertEquals($array, $rs);
    }

    /**
     * Provider of arrays to sanitize.
     * @array
     */
    public function providerSanitizeTags()
    {
        return array(
        	array(array('<script>alert("Some content");</script>hi'), array('alert(&#34;Some content&#34;);hi')),
            array(array('<a href="http://some.fucking.shit.com">link</a>'), array('link')),
            array(array('<b>hi</b>'), array('hi')),
        );
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::sanitize
     * @dataProvider providerSanitizeTags
     */
    public function testSanitizeTags($array, $expected)
    {
        $rs = arr::sanitize($array);
        $this->assertEquals($expected, $rs);
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::quotes
     */
    public function testQuotes()
    {
        $ar = array('param1', 'param2', 'param3');
        $rs = arr::quotes($ar);

        $this->assertInternalType('array', $rs);
    	$this->assertEquals(3, count($rs));

    	$this->assertInternalType('string', $rs[0]);
    	$this->assertEquals("'" . $ar[0] . "'", $rs[0]);

    	$this->assertInternalType('string', $rs[1]);
    	$this->assertEquals("'" . $ar[1] . "'", $rs[1]);

    	$this->assertInternalType('string', $rs[2]);
    	$this->assertEquals("'" . $ar[2] . "'", $rs[2]);
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::doubleQuotes
     */
    public function testDoubleQuotes()
    {
        $ar = array('param1', 'param2', 'param3');
        $rs = arr::doubleQuotes($ar);

        $this->assertInternalType('array', $rs);
        $this->assertEquals(3, count($rs));

        $this->assertInternalType('string', $rs[0]);
        $this->assertEquals('"' . $ar[0] . '"', $rs[0]);

        $this->assertInternalType('string', $rs[1]);
        $this->assertEquals('"' . $ar[1] . '"', $rs[1]);

        $this->assertInternalType('string', $rs[2]);
        $this->assertEquals('"' . $ar[2] . '"', $rs[2]);
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::toParamList
     */
    public function testToParamList()
    {
        $ar = array('param1', 'param2', 'param3');
        $rs = arr::toParamList($ar);

        $this->assertInternalType('string', $rs);
        $this->assertEquals("'param1','param2','param3'", $rs);
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::toXml
     */
    public function testToXml()
    {
        $array = array(
            'row1' => 'val1',
            'row2' => 'val2',
            'row3' => 'val3'
        );
        $xml = '<?xml version="1.0"?><root><row>val1</row><row>val2</row><row>val3</row></root>';
        $rs  = arr::toXml($array);
        $rs  = (string)preg_replace('/\n+/', '', trim($rs));

        $this->assertInternalType('string', $rs);
        $this->assertEquals($xml, $rs);
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::toObject
     */
    public function testToObject()
    {
        $array = array(
            'row1' => 'val1',
            'row2' => 'val2',
            'row3' => 'val3',
        );
        $rs = arr::toObject($array);

        $this->assertInstanceOf('stdClass', $rs);
        $this->assertEquals('val1', $rs->row1);
        $this->assertEquals('val2', $rs->row2);
        $this->assertEquals('val3', $rs->row3);
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::removeEmpty
     */
    public function testRemoveEmpty()
    {
        $empty = array(
            'row1' => 'val1',
            'row2' => '',
            'row3' => 'val3'
        );
        $final = array(
            'row1' => 'val1',
            'row3' => 'val3'
        );
        $rs = arr::removeEmpty($empty);
        $this->assertInternalType('array', $rs);
        $this->assertEquals($final, $rs);
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::search
     */
    public function testSearch()
    {
        $array = array(
            'argentina',
            'brasil',
            'brasilia',
            'chile'
        );
        $rs = arr::search($array, 'brasil');
        $rs = (string)preg_replace('/\n+/', '', trim($rs));

        $this->assertInternalType('string', $rs);
        $this->assertEquals($rs, '1,brasil2,brasilia');
    }

    /**
     * @see \Tbs\Helper\ArrayHelper::sort
     */
    public function testSort()
    {
        $array   = array();
        $array[] = array(
            'id'   => 2,
            'nome' => 'Bernardo',
        );
        $array[] = array(
            'id'   => 1,
            'nome' => 'Abílio',
        );
        $array[] = array(
            'id'   => 4,
            'nome' => 'Daniel',
        );
        $array[] = array(
            'id'   => 3,
            'nome' => 'Carlos',
        );

        $sorted = array(
            '0' => array(
                'id'   => 1,
                'nome' => 'Abílio',
            ),
            '1' => array(
                'id'   => 2,
                'nome' => 'Bernardo',
            ),
            '2' => array(
                'id'   => 3,
                'nome' => 'Carlos',
            ),
            '3' => array(
                'id'   => 4,
                'nome' => 'Daniel',
            ),
        );

        $rs = arr::sort($array, 'id');
        $this->assertInternalType('array', $rs);
        $this->assertEquals($sorted, $rs);

        $rs = arr::sort($array, 'nome');
        $this->assertInternalType('array', $rs);
        $this->assertEquals($sorted, $rs);
    }
}
