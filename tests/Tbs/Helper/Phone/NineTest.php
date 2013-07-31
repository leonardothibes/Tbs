<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\Phone;
use \Tbs\Helper\Phone\Nine as phone;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class NineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Phone\Nine
     */
    protected $object = null;

    /**
     * Setup.
     */
    public function setUp()
    {
    	$this->object = new phone();
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
        $this->assertInstanceOf('\Tbs\Helper\Interfaces\Mask'    , $this->object);
        $this->assertInstanceOf('\Tbs\Helper\Interfaces\Validate', $this->object);
    }

    /**
     * Provider of valid phone numbers.
     * @return array
     */
    public function providerValidPhones()
    {
        return array(
            array('(11) 12345-6789'),
            array('(11) 93188-9823'),
            array('(51) 99987-7673'),
        );
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::isValid()
     * @dataProvider providerValidPhones
     */
    public function testIsValid($phone)
    {
        $rs = phone::isValid($phone);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid phone numbers.
     * @return array
     */
    public function providerInvalidPhones()
    {
        return array(
            array(''),
            array(null),
            array(true),
            array(false),
            array('(11)93188-9823'),
            array('(11) 931889823'),
            array('(11) 93188 9823'),
            array('(11)93188-9823'),
            array('931889823'),
        );
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::isValid()
     * @dataProvider providerInvalidPhones
     */
    public function testIsInvalid($phone)
    {
        $rs = phone::isValid($phone);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::sanitize()
     * @dataProvider providerValidPhones
     */
    public function testSanitizeEquals($phone)
    {
        $rs = phone::sanitize($phone);
        $this->assertEquals($phone, $rs);
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::sanitize()
     * @dataProvider providerValidPhones
     */
    public function testSanitizeTags($phone)
    {
        $rs = phone::sanitize($phone . '<script>alert("some content");</script>');
        $this->assertEquals($phone, $rs);
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::isMasked()
     * @dataProvider providerValidPhones
     */
    public function testIsMasked($phone)
    {
        $rs = phone::isMasked($phone);
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::isMasked()
     * @dataProvider providerInvalidPhones
     */
    public function testIsUnMasked($phone)
    {
        $rs = phone::isMasked($phone);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::mask()
     */
    public function testMask()
    {
        $rs = phone::mask('99123456789');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('(99) 12345-6789', $rs);
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::unMask()
     */
    public function testUnMask()
    {
        $rs = phone::unMask('(99) 12345-6789');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('99123456789', $rs);
    }

    /**
     * @see \Tbs\Helper\Phone\Eight::unMaskToArray()
     */
    public function testUnMaskToArray()
    {
        $rs = phone::unMaskToArray('(99) 12345-6789');

        $this->assertInternalType('array', $rs);
        $this->assertEquals(2, count($rs));

        $this->assertArrayHasKey('ddd', $rs);
        $this->assertEquals('99', $rs['ddd']);

        $this->assertArrayHasKey('phone', $rs);
        $this->assertEquals('123456789', $rs['phone']);
    }
}
