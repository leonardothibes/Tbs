<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Html
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Html;
use \Tbs\Html\SpecialChars;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Html
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class SpecialCharsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Html\SpecialChars
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new SpecialChars;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Provider of constants and values.
     * @return array
     */
    public function providerConstantsValues()
    {
        return array(
            array('TAB_DEFAUL'   , "\11"),
            array('TAB_PSR'      , "    "),
            array('LINE_END_UNIX', "\12"),
            array('LINE_END_MAC' , "\15"),
            array('LINE_END_WIN' , "\15\12"),
        );
    }

    /**
     * @see \Tbs\Log\LogLevel
     * @dataProvider providerConstantsValues
     */
    public function testConstantsValues($constantName, $constantValue)
    {
        $class      = get_class($this->object);
        $reflection = new \ReflectionClass($class);
        $constants  = $reflection->getConstants();

        $this->assertInternalType('array', $constants);
        $this->assertArrayHasKey($constantName, $constants);
        $this->assertInternalType('string', $constants[$constantName]);
        $this->assertEquals($constantValue, $constants[$constantName]);
    }
}
