<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Library
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: MiscTest.php 21/06/2013 16:02:53 leonardo $
 */

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';
require_once 'Util/Misc.php';

/**
 * @category Tests
 * @package Library
 * @subpackage Models
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_MiscTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Misc
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

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
        $rs = Util\Misc::add($v1, $v2);
        $this->assertEquals($sum, $rs);
    }
}
