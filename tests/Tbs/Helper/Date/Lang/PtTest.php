<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper\Date\Lang;
use \Tbs\Helper\Date\Lang\Pt as lang;
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
            array('1' , 'janeiro'  ),
            array('2' , 'fevereiro'),
            array('3' , 'março'    ),
            array('4' , 'abril'    ),
            array('5' , 'maio'     ),
            array('6' , 'junho'    ),
            array('7' , 'julho'    ),
            array('8' , 'agosto'   ),
            array('9' , 'setembro' ),
            array('10', 'outubro'  ),
            array('11', 'novembro' ),
            array('12', 'dezembro' ),
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
