<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\Money as M;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Money
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new M;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Provider of numbers to convert.
     * @return array
     */
    public function providerMoneyToConvert()
    {
        return array(

            //Dolar to Number.
        	array('0.00'      , M::DOLAR, '0.00'),
            array('1.11'      , M::DOLAR, '1.11'),
            array('1.000'     , M::DOLAR, '1.00'),
            array('1000'      , M::DOLAR, '1000.00'),
            array('1234.56'   , M::DOLAR, '1234.56'),
            array('1000000.00', M::DOLAR, '1000000.00'),
            array('1000000'   , M::DOLAR, '1000000.00'),
            array('0.000'     , M::DOLAR, '0.00'),
            array('1.111'     , M::DOLAR, '1.11'),
            //Dolar to Number.

            //Real to Number.
            array('0,00'        , M::REAL, '0.00'),
            array('1,11'        , M::REAL, '1.11'),
            array('1,00'        , M::REAL, '1.00'),
            array('1000'        , M::REAL, '1000.00'),
            array('1.234,56'    , M::REAL, '1234.56'),
            array('1.000.000,00', M::REAL, '1000000.00'),
            array('1.000.000'   , M::REAL, '1000000.00'),
            array('0,000'       , M::REAL, '0.00'),
            array('1,111'       , M::REAL, '1.11'),
            //Real to Number.

            //Euro to Number.
            array('0,00'        , M::EURO, '0.00'),
            array('1,11'        , M::EURO, '1.11'),
            array('1,00'        , M::EURO, '1.00'),
            array('1000'        , M::EURO, '1000.00'),
            array('1.234,56'    , M::EURO, '1234.56'),
            array('1.000.000,00', M::EURO, '1000000.00'),
            array('1.000.000'   , M::EURO, '1000000.00'),
            array('0,000'       , M::EURO, '0.00'),
            array('1,111'       , M::EURO, '1.11'),
            //Euro to Number.
        );
    }

    /**
     * @see \Tbs\Helper\Money::toNumber()
     * @dataProvider providerMoneyToConvert
     */
    public function testToNumber($value, $format, $expected)
    {
        $rs = M::toNumber($value, $format);
        $this->assertInternalType('float', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * Provider of numbers to default convert.
     * @return array
     */
    public function providerMoneyToDefaultConvert()
    {
        return array(
            array('0,00'        , '0.00'),
            array('1,11'        , '1.11'),
            array('1,000'       , '1.00'),
            array('1000'        , '1000.00'),
            array('1.234,56'    , '1234.56'),
            array('1.000.000,00', '1000000.00'),
            array('1.000.000'   , '1000000.00'),
            array('0,000'       , '0.00'),
            array('1,111'       , '1.11'),
        );
    }

    /**
     * @see \Tbs\Helper\Money::toNumber()
     * @dataProvider providerMoneyToDefaultConvert
     */
    public function testToNumberDefaultConvert($value, $expected)
    {
        $rs = M::toNumber($value);
        $this->assertInternalType('float', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * @see \Tbs\Helper\Money::toNumber()
     * @dataProvider providerMoneyToConvert
     */
    public function testToNumberInvalidFormat($value, $format, $expected)
    {
        $rs = M::toNumber($value, 'invalid');
        $this->assertFalse($rs);
    }
}
