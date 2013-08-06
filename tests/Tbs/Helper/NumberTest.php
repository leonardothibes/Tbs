<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\Number as N;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class NumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Number
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new N;
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
    public function providerNumbersToConvert()
    {
        return array(

            //Number to Dolar.
        	array('0.00'      , N::DOLAR, '0.00'),
            array('1.11'      , N::DOLAR, '1.11'),
            array('1.000'     , N::DOLAR, '1.00'),
            array('1000'      , N::DOLAR, '1,000.00'),
            array('1234.56'   , N::DOLAR, '1,234.56'),
            array('1000000.00', N::DOLAR, '1,000,000.00'),
            array('1000000'   , N::DOLAR, '1,000,000.00'),

            array('0.000', N::DOLAR, '0.00'),
            array('1.111', N::DOLAR, '1.11'),
            //Number to Dolar.

            //Number to Real.
            array('0.00'      , N::REAL, '0,00'),
            array('1.11'      , N::REAL, '1,11'),
            array('1.000'     , N::REAL, '1,00'),
            array('1000'      , N::REAL, '1.000,00'),
            array('1234.56'   , N::REAL, '1.234,56'),
            array('1000000.00', N::REAL, '1.000.000,00'),
            array('1000000'   , N::REAL, '1.000.000,00'),

            array('0.000', N::REAL, '0,00'),
            array('1.111', N::REAL, '1,11'),
            //Number to Real.

            //Number to Euro.
            array('0.00'      , N::EURO, '0,00'),
            array('1.11'      , N::EURO, '1,11'),
            array('1.000'     , N::EURO, '1,00'),
            array('1000'      , N::EURO, '1.000,00'),
            array('1234.56'   , N::EURO, '1.234,56'),
            array('1000000.00', N::EURO, '1.000.000,00'),
            array('1000000'   , N::EURO, '1.000.000,00'),

            array('0.000', N::EURO, '0,00'),
            array('1.111', N::EURO, '1,11'),
            //Number to Euro.
        );
    }

    /**
     * @see \Tbs\Helper\Number::toMoney()
     * @dataProvider providerNumbersToConvert
     */
    public function testToMoney($number, $format, $expected)
    {
        $rs = N::toMoney($number, $format);
        $this->assertInternalType('string', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * Provider of numbers to default convert.
     * @return array
     */
    public function providerNumbersToDefaultConvert()
    {
        return array(
            array('0.00'      , '0,00'),
            array('1.11'      , '1,11'),
            array('1.000'     , '1,00'),
            array('1000'      , '1.000,00'),
            array('1234.56'   , '1.234,56'),
            array('1000000.00', '1.000.000,00'),
            array('1000000'   , '1.000.000,00'),
            array('0.000'     , '0,00'),
            array('1.111'     , '1,11'),
        );
    }

    /**
     * @see \Tbs\Helper\Number::toMoney()
     * @dataProvider providerNumbersToDefaultConvert
     */
    public function testToMoneyDefaultConvert($number, $expected)
    {
        $rs = N::toMoney($number);
        $this->assertInternalType('string', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * @see \Tbs\Helper\Number::toMoney()
     * @dataProvider providerNumbersToConvert
     */
    public function testToMoneyInvalidFormat($number, $format, $expected)
    {
        $rs = N::toMoney($number, 'invalid');
        $this->assertFalse($rs);
    }
}
