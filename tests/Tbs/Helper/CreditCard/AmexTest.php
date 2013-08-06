<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\CreditCard;
use \Tbs\Helper\CreditCard\Amex as Amex;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class AmexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\CreditCard\Amex
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new Amex;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
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
        $this->assertInstanceOf('\Tbs\Helper\CreditCard\Amex'    , $this->object);
    }

    /**
     * Provider of valid masked Amex numbers.
     * @return array
     */
    public function providerValidMasked()
    {
        return array(
            array('4532 9363 4876 4816'),
            array('4556 5182 8387 4759'),
            array('4739 9790 8349 0727'),
            array('4532 0722 1415 6430'),
            array('4916 3375 4981 6107'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::isValid()
     * @dataProvider providerValidMasked
     */
    public function testIsValidMasked($card)
    {
        $rs = Amex::isValid($card);
        $this->assertTrue($rs);
    }

    /**
     * Provider of valid unmasked Amex numbers.
     * @return array
     */
    public function providerValidUnMasked()
    {
        return array(
            array('4532936348764816'),
            array('4556518283874759'),
            array('4739979083490727'),
            array('4532072214156430'),
            array('4916337549816107'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::isValid()
     * @dataProvider providerValidUnMasked
     */
    public function testIsValidUnMasked($card)
    {
        $rs = Amex::isValid($card);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid Amex numbers.
     * @return array
     */
    public function providerInvalid()
    {
        return array(

            //Invalid types.
            array(''),
            array(null),
            array(true),
            array(false),
            //Invalid types.

            //Wrong First number.
            array('5532936348764816'),
            array('3532936348764816'),

            //Wrong digit
            array('4556518283874750'),

            //Mastercard
            array('5444 3605 1215 9683'),
            array('5444360512159683'),

            //Amex
            array('37113 636180 2724'),
            array('371136361802724'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::isValid()
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($card)
    {
        $rs = Amex::isValid($card);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::sanitize()
     * @dataProvider providerValidMasked
     */
    public function testSanitizeEqualsMasked($card)
    {
        $rs = Amex::sanitize($card);
        $this->assertEquals($card, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::sanitize()
     * @dataProvider providerValidUnMasked
     */
    public function testSanitizeEqualsUnMasked($card)
    {
        $rs = Amex::sanitize($card);
        $this->assertEquals(Amex::mask($card), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::sanitize()
     * @dataProvider providerValidMasked
     */
    public function testSanitizeTagsMasked($card)
    {
        $rs = Amex::sanitize($card . '<script>alert("some content");</script>');
        $this->assertEquals($card, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::sanitize()
     * @dataProvider providerValidUnMasked
     */
    public function testSanitizeTagsUnMasked($card)
    {
        $rs = Amex::sanitize($card . '<script>alert("some content");</script>');
        $this->assertEquals(Amex::mask($card), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::isMasked()
     * @dataProvider providerValidMasked
     */
    public function testIsMasked($card)
    {
        $rs = Amex::isMasked($card);
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::isMasked()
     * @dataProvider providerValidUnMasked
     */
    public function testIsUnMasked($card)
    {
        $rs = Amex::isMasked($card);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::mask()
     */
    public function testMask()
    {
        $rs = Amex::mask('1111222233334444');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('1111 2222 3333 4444', $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Amex::mask()
     */
    public function testUnMask()
    {
        $rs = Amex::unMask('1111 2222 3333 4444');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('1111222233334444', $rs);
    }
}
