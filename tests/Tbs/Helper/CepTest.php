<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\Cep as cep;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class CepTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Cep
     */
    protected $object = null;

    /**
     * Setup.
     */
    public function setUp()
    {
    	$this->object = new cep;
    }

    /**
     * TearDown.
     */
    public function tearDown()
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
    }

    /**
     * Provider of valid CEP numbers.
     * @return array
     */
    public function providerValidCeps()
    {
        return array(
        	array('01315-010'),
            array('01232-001'),
            array('04311-080'),
        );
    }

    /**
     * @see \Tbs\Helper\Cep::isValid()
     * @dataProvider providerValidCeps
     */
    public function testIsValid($cep)
    {
        $rs = cep::isValid($cep);
        $this->assertTrue($rs);
    }
}




























