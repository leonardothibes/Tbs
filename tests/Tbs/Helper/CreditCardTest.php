<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;

use \Tbs\Helper\CreditCard\Master as Master;
use \Tbs\Helper\CreditCard\Visa   as Visa;
use \Tbs\Helper\CreditCard\Amex   as Amex;
use \Tbs\Helper\CreditCard        as Card;

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class CreditCardTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\CreditCard
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new Card;
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
        $this->assertInstanceOf('\Tbs\Helper\Interfaces\Validate', $this->object);
    }

    /**
     * Provider of valid masked numbers.
     * @return array
     */
    public function providerValidMasked()
    {
        return array(

            //Mastercard.
            array('5444 3605 1215 9683'),

            //Visa.
            array('4532 9363 4876 4816'),

            //Amex
            array('37906 944122 4084'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard::isValid()
     * @dataProvider providerValidMasked
     */
    public function testIsValidMasked($card)
    {
        $rs = Card::isValid($card);
        $this->assertTrue($rs);
    }

    /**
     * Provider of valid unmasked numbers.
     * @return array
     */
    public function providerValidUnMasked()
    {
        return array(

            //Mastercard.
            array('5444360512159683'),

            //Visa.
            array('4532936348764816'),

            //Amex.
            array('379069441224084'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard::isValid()
     * @dataProvider providerValidUnMasked
     */
    public function testIsValidUnMasked($card)
    {
        $rs = Card::isValid($card);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid numbers.
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

            //Mastercard wrong digit.
            array('5444360512159684'),

            //Visa wrong digit.
            array('4532936348764817'),

            //Amex wrong digit.
            array('379069441224085'),
        );
    }

    /**
     * @see \Tbs\Helper\CreditCard::isValid()
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($card)
    {
        $rs = Card::isValid($card);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeEqualsVisaMasked()
    {
        $visa = '4556 5182 8387 4759';
        $rs   = Card::sanitize($visa);
        $this->assertEquals($visa, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeEqualsVisaUnMasked()
    {
        $visa = '4556518283874759';
        $rs   = Card::sanitize($visa);
        $this->assertEquals(Visa::mask($visa), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeTagsVisaMasked()
    {
        $visa = '4556 5182 8387 4759';
        $rs   = Card::sanitize($visa . '<script>alert("some content");</script>');
        $this->assertEquals($visa, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeTagsVisaUnMasked()
    {
        $visa = '4556518283874759';
        $rs   = Card::sanitize($visa . '<script>alert("some content");</script>');
        $this->assertEquals(Visa::mask($visa), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeEqualsMasterMasked()
    {
        $master = '5444 3605 1215 9683';
        $rs     = Card::sanitize($master);
        $this->assertEquals($master, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeEqualsMasterUnMasked()
    {
        $master = '5444360512159683';
        $rs     = Card::sanitize($master);
        $this->assertEquals(Master::mask($master), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeTagsMasterMasked()
    {
        $master = '5444 3605 1215 9683';
        $rs     = Card::sanitize($master . '<script>alert("some content");</script>');
        $this->assertEquals($master, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeTagsMasterUnMasked()
    {
        $master = '5444360512159683';
        $rs     = Card::sanitize($master . '<script>alert("some content");</script>');
        $this->assertEquals(Master::mask($master), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeEqualsAmexMasked()
    {
        $amex = '37113 636180 2724';
        $rs   = Card::sanitize($amex);
        $this->assertEquals($amex, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeEqualsAmexUnMasked()
    {
        $amex = '371136361802724';
        $rs   = Card::sanitize($amex);
        $this->assertEquals(Amex::mask($amex), $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeTagsAmexMasked()
    {
        $amex = '37113 636180 2724';
        $rs   = Card::sanitize($amex . '<script>alert("some content");</script>');
        $this->assertEquals($amex, $rs);
    }

    /**
     * @see \Tbs\Helper\CreditCard::sanitize()
     */
    public function testSanitazeTagsAmexUnMasked()
    {
        $amex = '371136361802724';
        $rs   = Card::sanitize($amex . '<script>alert("some content");</script>');
        $this->assertEquals(Amex::mask($amex), $rs);
    }
}
