<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\Cnpj as cnpj;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class CnpjTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Cnpj
     */
    protected $object = null;

    /**
     * Setup.
     */
    public function setUp()
    {
    	$this->object = new cnpj;
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
     * Provider of valid CNPJ numbers.
     * @return array
     */
    public function providerValidCnpjs()
    {
        return array(

            array('74.067.933/0001-32'),
            array('74067933000132'),

            array('61.840.848/0001-13'),
            array('61840848000113'),

            array('49.553.345/0001-61'),
            array('49553345000161'),
        );
    }

    /**
     * @see \Tbs\Helper\Cnpj::isValid()
     * @dataProvider providerValidCnpjs
     */
    public function testIsValid($cnpj)
    {
        $rs = cnpj::isValid($cnpj);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid CNPJ numbers.
     * @return array
     */
    public function providerInvalidCnpjs()
    {
        return array(

        	array('11.111.111/1111-11'),
            array('11111111111111'),

            array('22.222.222/2222-22'),
            array('22222222222222'),

            array('33.333.333/3333-33'),
            array('33333333333333'),

            array('44.444.444/4444-44'),
            array('44444444444444'),

            array('55.555.555/5555-55'),
            array('55555555555555'),

            array('66.666.666/6666-66'),
            array('66666666666666'),

            array('77.777.777/7777-77'),
            array('77777777777777'),

            array('88.888.888/8888-88'),
            array('88888888888888'),

            array('99.999.999/9999-99'),
            array('99999999999999'),

            array('74.067.933/0001-33'),
            array('74067933000133'),

            array('61.840.848/0001-14'),
            array('61840848000114'),

            array('49.553.345/0001-62'),
            array('49553345000162'),
        );
    }

    /**
     * @see \Tbs\Helper\Cnpj::isValid()
     * @dataProvider providerInvalidCnpjs
     */
    public function testIsInvalid($cnpj)
    {
        $rs = cnpj::isValid($cnpj);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Cnpj::sanitize()
     * @dataProvider providerValidCnpjs
     */
    public function testSanitizeEquals($cnpj)
    {
        $rs   = cnpj::sanitize($cnpj);
        $cnpj = cnpj::mask($cnpj);
        $this->assertEquals($cnpj, $rs);
    }

    /**
     * @see \Tbs\Helper\Cnpj::sanitize()
     * @dataProvider providerValidCnpjs
     */
    public function testSanitizeTags($cnpj)
    {
        $cnpj = cnpj::mask($cnpj);
        $rs   = cnpj::sanitize($cnpj . '<script>alert("some content");</script>');
        $this->assertEquals($cnpj, $rs);
    }

    /**
     * Provider of masked CNPJ numbers(valid and invalid).
     * @return array
     */
    public function providerMaskedCnpjs()
    {
        return array(
            array('74.067.933/0001-32'),
            array('61.840.848/0001-13'),
            array('49.553.345/0001-61'),
        );
    }

    /**
     * @see \Tbs\Helper\Cnpj::isMasked()
     * @dataProvider providerMaskedCnpjs
     */
    public function testIsMasked($cnpj)
    {
        $rs = cnpj::isMasked($cnpj);
        $this->assertTrue($rs);
    }

    /**
     * Provider of unmasked CNPJ numbers(valid and invalid).
     * @return array
     */
    public function providerUnmaskedCpfs()
    {
        return array(
            array('74067933000132'),
            array('61840848000113'),
            array('49553345000161'),
        );
    }

    /**
     * @see \Tbs\Helper\Cnpj::isMasked()
     * @dataProvider providerUnmaskedCpfs
     */
    public function testIsUnMasked($cnpj)
    {
        $rs = cnpj::isMasked($cnpj);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Cnpj::mask()
     */
    public function testMask()
    {
        $rs = cnpj::mask('74067933000132');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('74.067.933/0001-32', $rs);
    }

    /**
     * @see \Tbs\Helper\Cnpj::unMask()
     */
    public function testUnMask()
    {
        $rs = cnpj::unMask('74.067.933/0001-32');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('74067933000132', $rs);
    }

    /**
     * @see \Tbs\Helper\Cnpj::random()
     */
    public function testRandom()
    {
        for ($i = 1; $i <= 5; $i++) {

            $rs = cnpj::random();
            $this->assertEquals(14, strlen($rs));
            $this->assertTrue(is_numeric($rs));
            $this->assertTrue(cnpj::isValid($rs));

            $rs = cnpj::random(true);
            $this->assertRegExp('/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/', $rs);
            $this->assertTrue(cnpj::isValid($rs));
        }
    }
}
