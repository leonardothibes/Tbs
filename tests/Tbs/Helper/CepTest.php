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

    /**
     * Provider of invalid CEP numbers.
     * @return array
     */
    public function providerInvalidCeps()
    {
        return array(
            array(''),
            array('01315010'),
            array('01232001'),
            array('04311080'),
        );
    }

    /**
     * @see \Tbs\Helper\Cep::isValid()
     * @dataProvider providerInvalidCeps
     */
    public function testIsInvalid($cep)
    {
        $rs = cep::isValid($cep);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Cep::sanitize()
     * @dataProvider providerValidCeps
     */
    public function testSanitizeEquals($cep)
    {
        $rs = cep::sanitize($cep);
        $this->assertEquals($cep, $rs);
    }

    /**
     * @see \Tbs\Helper\Cep::sanitize()
     * @dataProvider providerValidCeps
     */
    public function testSanitizeTags($cep)
    {
        $rs = cep::sanitize($cep . '<script>alert("some content");</script>');
        $this->assertEquals($cep, $rs);
    }

    /**
     * @see \Tbs\Helper\Cep::isMasked()
     * @dataProvider providerValidCeps
     */
    public function testIsMasked($cep)
    {
        $rs = cep::isMasked($cep);
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\Helper\Cep::isMasked()
     * @dataProvider providerValidCeps
     */
    public function testIsUnMasked($cep)
    {
        $cep = str_replace('-', '', trim($cep));
        $rs  = cep::isMasked($cep);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Cep::mask()
     */
    public function testMask()
    {
        $rs = cep::mask('12345678');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('12345-678', $rs);
    }

    /**
     * @see \Tbs\Helper\Cep::unMask()
     */
    public function testUnMask()
    {
        $rs = cep::unMask('12345-678');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('12345678', $rs);
    }
}
