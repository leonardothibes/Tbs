<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\CreditCard;
use \Tbs\Helper\CreditCard\Master as Master;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class MasterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\CreditCard\Master
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new Master;
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
        $this->assertInstanceOf('\Tbs\Helper\CreditCard\Master'    , $this->object);
    }

    /**
     * Provider of valid masked Master numbers.
     * @return array
     */
    public function providerValidMasked()
    {
        return array(
            array('5506 1055 0008 0903'),
            array('5187 6936 9552 8717'),
            array('5367 2636 3307 7078'),
            array('5159 3352 2902 1652'),
            array('5444 3605 1215 9683'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::isValid()
     * @dataProvider providerValidMasked
     */
    public function testIsValidMasked($card)
    {
        $rs = Master::isValid($card);
        $this->assertTrue($rs);
    }

    /**
     * Provider of valid unmasked Master numbers.
     * @return array
     */
    public function providerValidUnMasked()
    {
        return array(
            array('5506105500080903'),
            array('5187693695528717'),
            array('5367263633077078'),
            array('5159335229021652'),
            array('5444360512159683'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::isValid()
     * @dataProvider providerValidUnMasked
     */
    public function testIsValidUnMasked($card)
    {
        $rs = Master::isValid($card);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid Master numbers.
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
            array('3444360512159683'),
            array('4444360512159683'),

            //Wrong digit
            array('5159335229021653'),

            //Visa
            array('4532 9363 4876 4816'),
            array('4532936348764816'),

            //Amex
            array('37113 636180 2724'),
            array('371136361802724'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::isValid()
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($card)
    {
        $rs = Master::isValid($card);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::sanitize()
     * @dataProvider providerValidMasked
     */
    public function testSanitizeEqualsMasked($card)
    {
        $rs = Master::sanitize($card);
        $this->assertEquals($card, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::sanitize()
     * @dataProvider providerValidUnMasked
     */
    public function testSanitizeEqualsUnMasked($card)
    {
        $rs = Master::sanitize($card);
        $this->assertEquals(Master::mask($card), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::sanitize()
     * @dataProvider providerValidMasked
     */
    public function testSanitizeTagsMasked($card)
    {
        $rs = Master::sanitize($card . '<script>alert("some content");</script>');
        $this->assertEquals($card, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::sanitize()
     * @dataProvider providerValidUnMasked
     */
    public function testSanitizeTagsUnMasked($card)
    {
        $rs = Master::sanitize($card . '<script>alert("some content");</script>');
        $this->assertEquals(Master::mask($card), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::isMasked()
     * @dataProvider providerValidMasked
     */
    public function testIsMasked($card)
    {
        $rs = Master::isMasked($card);
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::isMasked()
     * @dataProvider providerValidUnMasked
     */
    public function testIsUnMasked($card)
    {
        $rs = Master::isMasked($card);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::mask()
     */
    public function testMask()
    {
        $rs = Master::mask('1111222233334444');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('1111 2222 3333 4444', $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard\Master::mask()
     */
    public function testUnMask()
    {
        $rs = Master::unMask('1111 2222 3333 4444');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('1111222233334444', $rs);
    }
}
