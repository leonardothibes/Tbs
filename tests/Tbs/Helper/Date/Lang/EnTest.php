<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\Date\Lang;
use \Tbs\Helper\Date\Lang\En as lang;
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class PtTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Tbs\Helper\Interfaces\Date\Lang
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new lang;
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
        $this->assertInstanceOf('\Tbs\Helper\Date\Lang\AbstractLang', $this->object);
        $this->assertInstanceOf('\Tbs\Helper\Interfaces\DateLang'   , $this->object);
    }

    /**
     * Month names provider.
     * @return array
     */
    public function providerMonthNames()
    {
        return array(
            array('1' , 'january'  ),
            array('2' , 'february' ),
            array('3' , 'march'    ),
            array('4' , 'april'    ),
            array('5' , 'may'      ),
            array('6' , 'june'     ),
            array('7' , 'july'     ),
            array('8' , 'august'   ),
            array('9' , 'september'),
            array('10', 'october'  ),
            array('11', 'november' ),
            array('12', 'december' ),
        );
    }

    /**
     * @see \Tbs\Helper\Date\Lang::getMonthName()
     * @dataProvider providerMonthNames
     */
    public function testGetMonthName($number, $name)
    {
        $rs = $this->object->getMonthName($number);
        $this->assertEquals($name, $rs);
    }
}
