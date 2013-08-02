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
    }
}





























