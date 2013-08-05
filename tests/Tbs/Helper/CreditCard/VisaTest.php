<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\CreditCard;
use \Tbs\Helper\CreditCard\Visa as Visa;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class VisaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\CreditCard\Visa
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new Visa;
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
        $this->assertInstanceOf('\Tbs\Helper\CreditCard\Visa'    , $this->object);
    }

    /**
     * Provider of valid masked Visa numbers.
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
     * @see \Tbs\Helper\CreditCard\Visa::isValid()
     * @dataProvider providerValidMasked
     */
    public function testIsValidMasked($card)
    {
        $rs = Visa::isValid($card);
        $this->assertTrue($rs);
    }

    /**
     * Provider of valid unmasked Visa numbers.
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
     * @see \Tbs\Helper\CreditCard\Visa::isValid()
     * @dataProvider providerValidUnMasked
     */
    public function testIsValidUnMasked($card)
    {
        $rs = Visa::isValid($card);
        $this->assertTrue($rs);
    }
}
















