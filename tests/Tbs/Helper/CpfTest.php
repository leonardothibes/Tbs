<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\Cpf as cpf;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class CpfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\Cpf
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new cpf;
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
    	$this->assertInstanceOf('\Tbs\Helper\Interfaces\Mask'    , $this->object);
    	$this->assertInstanceOf('\Tbs\Helper\Interfaces\Validate', $this->object);
    }

    /**
     * Provider of valid CPF numbers.
     * @return array
     */
    public function providerValidCpfs()
    {
        return array(
            array('897.478.455-63'),
            array('89747845563'   ),
            array('353.584.816-48'),
            array('35358481648'   ),
            array('894.254.992-68'),
            array('89425499268'   ),
        );
    }

    /**
     * @see \Tbs\Helper\Cpf::isValid()
     * @dataProvider providerValidCpfs
     */
    public function testIsValid($cpf)
    {
        $rs = cpf::isValid($cpf);
        $this->assertTrue($rs);
    }

    /**
     * Provider of invalid CPF numbers.
     * @return array
     */
    public function providerInvalidCpfs()
    {
        return array(

            array(''),

        	array('123.456.789-09'),
            array('12345678909'),

            array('111.111.111-11'),
            array('11111111111'),

            array('222.222.222-22'),
            array('22222222222'),

            array('333.333.333-33'),
            array('33333333333'),

            array('444.444.444-44'),
            array('44444444444'),

            array('555.555.555-55'),
            array('55555555555'),

            array('666.666.666-66'),
            array('66666666666'),

            array('777.777.777-77'),
            array('77777777777'),

            array('888.888.888-88'),
            array('88888888888'),

            array('999.999.999-99'),
            array('99999999999'),

            array('000.000.000-00'),
            array('00000000000'),

            array('897.478.455-64'),
            array('89747845564'   ),
            array('353.584.816-49'),
            array('35358481649'   ),
            array('894.254.992-69'),
            array('89425499269'   ),
        );
    }

    /**
     * @see \Tbs\Helper\Cpf::isValid()
     * @dataProvider providerInvalidCpfs
     */
    public function testIsInvalid($cpf)
    {
        $rs = cpf::isValid($cpf);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Cpf::sanitize()
     * @dataProvider providerValidCpfs
     */
    public function testSanitizeEquals($cpf)
    {
        $rs = cpf::sanitize($cpf);
        $this->assertEquals($cpf, $rs);
    }

    /**
     * @see \Tbs\Helper\Cpf::sanitize()
     * @dataProvider providerValidCpfs
     */
    public function testSanitizeTags($cpf)
    {
        $rs = cpf::sanitize($cpf . '<script>alert("some content");</script>');
        $this->assertEquals($cpf . 'alert(&#34;some content&#34;);', $rs);
    }

    /**
     * Provider of masked CPF numbers(valid and invalid).
     * @return array
     */
    public function providerMaskedCpfs()
    {
        return array(
            array('897.478.455-63'),
            array('897.478.455-64'),
            array('353.584.816-48'),
            array('353.584.816-49'),
            array('894.254.992-68'),
            array('894.254.992-69'),
        );
    }

    /**
     * @see \Tbs\Helper\Cpf::isMasked()
     * @dataProvider providerMaskedCpfs
     */
    public function testIsMasked($cpf)
    {
        $rs = cpf::isMasked($cpf);
        $this->assertTrue($rs);
    }

    /**
     * Provider of unmasked CPF numbers(valid and invalid).
     * @return array
     */
    public function providerUnmaskedCpfs()
    {
        return array(
            array('89747845563'),
            array('89747845564'),
            array('35358481648'),
            array('35358481649'),
            array('89425499268'),
            array('89425499269'),
        );
    }

    /**
     * @see \Tbs\Helper\Cpf::isMasked()
     * @dataProvider providerUnmaskedCpfs
     */
    public function testIsUnMasked($cpf)
    {
        $rs = cpf::isMasked($cpf);
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\Helper\Cpf::mask()
     */
    public function testMask()
    {
        $rs = cpf::mask('12345678900');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('123.456.789-00', $rs);
    }

    /**
     * @see \Tbs\Helper\Cpf::unMask()
     */
    public function testUnMask()
    {
        $rs = cpf::unMask('123.456.789-00');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('12345678900', $rs);
    }

    /**
     * @see \Tbs\Helper\Cpf::random()
     */
    public function testRandom()
    {
        for ($i = 1; $i <= 5; $i++) {

            $rs = cpf::random();
            $this->assertEquals(11, strlen($rs));
            $this->assertTrue(is_numeric($rs));
            $this->assertTrue(cpf::isValid($rs));

            $rs = cpf::random(true);
            $this->assertRegExp('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2}$/', $rs);
            $this->assertTrue(cpf::isValid($rs));
        }
    }
}
