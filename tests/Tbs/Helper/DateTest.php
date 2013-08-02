<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\Date as date;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class DateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Date
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new date;
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
     * Provider of valid dates.
     * @return array
     */
    public function providerValidDates()
    {
        return array(
            array('01/08/1984'),
            array('16/11/2010'),
            array('29/02/2008'),
        );
    }

    /**
     * @see \Tbs\Helper\Date::isValid()
     * @dataProvider providerValidDates
     */
    public function testIsValid($date)
    {
        $rs = date::isValid($date);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid dates.
     * @return array
     */
    public function providerInvalidDates()
    {
        return array(
            array('01/13/1984'),
            array('32/11/2010'),
            array('29/02/2009'),
            array('31/11/2010'),
            array('31/11/201'),
            array('31/111/2010'),
            array(true),
            array(false),
            array(null),
            array(''),
        );
    }

    /**
     * @see \Tbs\Helper\Date::isValid()
     * @dataProvider providerInvalidDates
     */
    public function testIsInvalid($date)
    {
        $rs = date::isValid($date);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Date::sanitize()
     * @dataProvider providerValidDates
     */
    public function testsanitize($date)
    {
        $rs = date::sanitize($date);
        $this->assertEquals($date, $rs);
    }

    /**
     * Provider of years list.
     * @return array
     */
    public function providerYearsList()
    {
        return array(
            array(1, 2010, array(2010 => 2010, 2009 => 2009)),
            array(2, 2010, array(2010 => 2010, 2009 => 2009, 2008 => 2008)),
            array(3, 2010, array(2010 => 2010, 2009 => 2009, 2008 => 2008, 2007 => 2007)),
    	);
    }

    /**
     * @see \Tbs\Helper\Date::yearsList()
     * @dataProvider providerYearsList
     */
    public function testYearsList($amount, $last, $expected)
    {
        $rs = date::yearsList($amount, $last);
        $this->assertInternalType('array', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * Provider of years range.
     * @return array
     */
    public function providerYearsRange()
    {
        return array(
            array(2005, 2007, array(2007 => 2007, 2006 => 2006, 2005 => 2005)),
            array(2008, 2010, array(2010 => 2010, 2009 => 2009, 2008 => 2008)),
            array(2008, 2013, array(2013 => 2013, 2012 => 2012, 2011 => 2011, 2010 => 2010, 2009 => 2009, 2008 => 2008)),
        );
    }

    /**
     * @see \Tbs\Helper\Date::yearsRange()
     * @dataProvider providerYearsRange
     */
    public function testYearsRange($first, $last, $expected)
    {
        $rs = date::yearsRange($first, $last, $expected);
        $this->assertInternalType('array', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * Provider of months and years to test last day.
     * @return array
     */
    public function providerLastDay()
    {
        return array(

            //2011.
            array(1, 2011, 31),
            array(2, 2011, 28),
            array(3, 2011, 31),
            array('01', 2011, 31),
            array('02', 2011, 28),
            array('03', 2011, 31),
            array(10, 2011, 31),
            array(11, 2011, 30),
            array(12, 2011, 31),

            //2012.
            array(1, 2012, 31),
            array(2, 2012, 29),
            array(3, 2012, 31),
            array('01', 2012, 31),
            array('02', 2012, 29),
            array('03', 2012, 31),
            array(10, 2012, 31),
            array(11, 2012, 30),
            array(12, 2012, 31),
        );
    }

    /**
     * @see \Tbs\Helper\Date::lastDay()
     * @dataProvider providerLastDay
     */
    public function testLastDay($month, $year, $expected)
    {
        $rs = date::lastDay($month, $year);
        $this->assertInternalType('int', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * Month names provider.
     * @return array
     */
    public function providerMonthNames()
    {
        return array(

            //En
            array('1' , 'january'  , 'en'),
            array('2' , 'february' , 'en'),
            array('3' , 'march'    , 'en'),
            array('4' , 'april'    , 'en'),
            array('5' , 'may'      , 'en'),
            array('6' , 'june'     , 'en'),
            array('7' , 'july'     , 'en'),
            array('8' , 'august'   , 'en'),
            array('9' , 'september', 'en'),
            array('10', 'october'  , 'en'),
            array('11', 'november' , 'en'),
            array('12', 'december' , 'en'),

            //Pt
            array('1' , 'janeiro'  , 'pt'),
            array('2' , 'fevereiro', 'pt'),
            array('3' , 'março'    , 'pt'),
            array('4' , 'abril'    , 'pt'),
            array('5' , 'maio'     , 'pt'),
            array('6' , 'junho'    , 'pt'),
            array('7' , 'julho'    , 'pt'),
            array('8' , 'agosto'   , 'pt'),
            array('9' , 'setembro' , 'pt'),
            array('10', 'outubro'  , 'pt'),
            array('11', 'novembro' , 'pt'),
            array('12', 'dezembro' , 'pt'),

            //Br
            array('1' , 'janeiro'  , 'br'),
            array('2' , 'fevereiro', 'br'),
            array('3' , 'março'    , 'br'),
            array('4' , 'abril'    , 'br'),
            array('5' , 'maio'     , 'br'),
            array('6' , 'junho'    , 'br'),
            array('7' , 'julho'    , 'br'),
            array('8' , 'agosto'   , 'br'),
            array('9' , 'setembro' , 'br'),
            array('10', 'outubro'  , 'br'),
            array('11', 'novembro' , 'br'),
            array('12', 'dezembro' , 'br'),
        );
    }

    /**
     * @see \Tbs\Helper\Date::monthName()
     * @dataProvider providerMonthNames
     */
    public function testMonthName($number, $name, $lang)
    {
        $rs = date::monthName($number, $lang);
        $this->assertInternalType('string', $rs);
        $this->assertEquals($name, $rs);
    }

    /**
     * Month names provider.
     * @return array
     */
    public function providerShortMonthName()
    {
        return array(

            //En
            array('1' , 'jan', 'en'),
            array('2' , 'feb', 'en'),
            array('3' , 'mar', 'en'),
            array('4' , 'apr', 'en'),
            array('5' , 'may', 'en'),
            array('6' , 'jun', 'en'),
            array('7' , 'jul', 'en'),
            array('8' , 'aug', 'en'),
            array('9' , 'sep', 'en'),
            array('10', 'oct', 'en'),
            array('11', 'nov', 'en'),
            array('12', 'dec', 'en'),

            //Pt
            array('1' , 'jan', 'pt'),
            array('2' , 'fev', 'pt'),
            array('3' , 'mar', 'pt'),
            array('4' , 'abr', 'pt'),
            array('5' , 'mai', 'pt'),
            array('6' , 'jun', 'pt'),
            array('7' , 'jul', 'pt'),
            array('8' , 'ago', 'pt'),
            array('9' , 'set', 'pt'),
            array('10', 'out', 'pt'),
            array('11', 'nov', 'pt'),
            array('12', 'dez', 'pt'),

            //Br
            array('1' , 'jan', 'pt'),
            array('2' , 'fev', 'pt'),
            array('3' , 'mar', 'pt'),
            array('4' , 'abr', 'pt'),
            array('5' , 'mai', 'pt'),
            array('6' , 'jun', 'pt'),
            array('7' , 'jul', 'pt'),
            array('8' , 'ago', 'pt'),
            array('9' , 'set', 'pt'),
            array('10', 'out', 'pt'),
            array('11', 'nov', 'pt'),
            array('12', 'dez', 'pt'),
        );
    }

    /**
     * @see \Tbs\Helper\Date::shortMonthName()
     * @dataProvider providerShortMonthName
     */
    public function testShortMonthName($number, $name, $lang)
    {
        $rs = date::shortMonthName($number, $lang);
        $this->assertInternalType('string', $rs);
        $this->assertEquals($name, $rs);
    }
}
