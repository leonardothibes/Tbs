<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Application
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: CalculatorTest.php 21/06/2013 15:48:27 leonardo $
 */

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';
require_once 'Calculator.php';

/**
 * @category Tests
 * @package Application
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Calculator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Phpskel\Calculator;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->object);
    }

    /**
     * Number to sum.
     * @return array
     */
    public function providerAdd()
    {
        return array(
            array(1, 1, 2),
            array(1, 2, 3),
            array(2, 2, 4),
        );
    }

    /**
     * Testing sum.
     * @dataProvider providerAdd
     */
    public function testAdd($v1, $v2, $sum)
    {
        $rs = $this->object->add($v1, $v2);
        $this->assertEquals($sum, $rs);
    }

    /**
     * Invalid numbers to sum.
     * @return array
     */
    public function providerInvalidNumbers()
    {
        return array(
			array(1, 'a'),
			array('a', 1),
			array('a', 'a'),
            array('', '')
        );
    }

	/**
	 * Testing exception of sum.
	 * @dataProvider providerInvalidNumbers
	 * @expectedException \Exception
	 */
	public function testAddException($v1, $v2)
	{
		$this->object->add($v1, $v2);
	}
}
