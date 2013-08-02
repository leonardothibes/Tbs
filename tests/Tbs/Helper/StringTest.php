<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Helper\String as string;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class StringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Helper\String
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new string;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Provider of a invalid strings.
     * @return array
     */
    public function providerSanitize()
    {
        return array
        (
            array('string', '', 'string'),
            array('á é í ó ú', '', 'á é í ó ú'),

            array('<b>string</b>', '', 'string'),
            array('<b>string</b>', '<b>', '<b>string</b>'),
            array('<b><i>string</i></b>', '<b>', '<b>string</b>'),
            array('<b><i>string</i></b>', '*', '<b><i>string</i></b>'),

            array('<a href="/path/to/the/link">link</a>', '', 'link'),
            array('<a href="/path/to/the/link">link</a>', '<a>', '<a href=\"/path/to/the/link\">link</a>'),
            array('<a href="/path/to/the/link"><b>link</b></a>', '<a>', '<a href=\"/path/to/the/link\">link</a>'),
            array('<a href="/path/to/the/link"><b>link</b></a>', '*', '<a href=\"/path/to/the/link\"><b>link</b></a>'),

            array('--INSERT INTO injection_table VALUES(value1, value2)', '*', 'INSERT INTO injection_table VALUES(value1, value2)'),
            array('--INSERT INTO injection_table VALUES(value1, value2)', '', 'INSERT INTO injection_table VALUES(value1, value2)')
        );
    }

    /**
     * @see \Tbs\Helper\String::sanitize()
     * @dataProvider providerSanitize
     */
    public function testSanitize($string, $tags, $expected)
    {
        $rs = string::sanitize($string, $tags);
        $this->assertInternalType('string', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * Provider of strings to concatenate.
     * @return array
     */
    public function providerConcatenate()
    {
        return array(
        	array('1', '2', '3', '1, 2, 3'),
            array('a', 'b', 'c', 'a, b, c'),
            array('!', '@', '#', '!, @, #'),
        );
    }

    /**
     * @see \Tbs\Helper\String()
     * @dataProvider providerConcatenate
     */
    public function testConcatenate($c1, $c2, $c3, $expected)
    {
        string::concatenate($str, $c1);
        string::concatenate($str, $c2);
        string::concatenate($str, $c3);
        $this->assertEquals($expected, $str);
    }

    /**
     * @see \Tbs\Helper\String::addQuotes()
     */
    public function testQuotes()
    {
        $rs = string::quotes('string');
        $this->assertInternalType('string', $rs);
        $this->assertEquals("'string'", $rs);
    }

    /**
     * @see \Tbs\Helper\String::addDoubleQuotes()
     */
    public function testDoubleQuotes()
    {
        $rs = string::doubleQuotes('string');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('"string"', $rs);
    }

    /**
     * @see \Tbs\Helper\String::firstSlash()
     */
    public function testFirstSlashWithoutSlash()
    {
        $rs = string::firstSlash('string');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('/string', $rs);
    }

    /**
     * @see \Tbs\Helper\String::firstSlash()
     */
    public function testFirstSlashWithSlash()
    {
        $rs = string::firstSlash('/string');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('/string', $rs);
    }

    /**
     * @see \Tbs\Helper\String::lastSlash()
     */
    public function testLastSlashWithoutSlash()
    {
        $rs = string::lastSlash('string');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('string/', $rs);
    }

    /**
     * @see \Tbs\Helper\String::lasttSlash()
     */
    public function testLastSlashWithSlash()
    {
        $rs = string::lastSlash('string/');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('string/', $rs);
    }

    /**
     * @see \Tbs\Helper\String::truncate()
     */
    public function testTruncate1()
    {
        $rs = string::truncate('This is a phrase very much, but very long, even');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('This is a phrase very much, b...', $rs);
    }

    /**
     * @see \Tbs\Helper\String::truncate()
     */
    public function testTruncate2()
    {
        $rs = string::truncate('This is a phrase very much, but very long, even', 30);
        $this->assertInternalType('string', $rs);
        $this->assertEquals('This is a phrase very much, b...', $rs);
    }

    /**
     * @see \Tbs\Helper\String::truncate()
     */
    public function testTruncate3()
    {
        $rs = string::truncate('This is a phrase very much, but very long, even', 30, '...');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('This is a phrase very much, b...', $rs);
    }

    /**
     * @see \Tbs\Helper\String::truncate()
     */
    public function testTruncate4()
    {
        $rs = string::truncate('This is a phrase very much, but very long, even', 10);
        $this->assertInternalType('string', $rs);
        $this->assertEquals('This is a...', $rs);
    }

    /**
     * @see \Tbs\Helper\String::truncate
     */
    public function testTruncate5()
    {
        $rs = string::truncate('This is a phrase very much, but very long, even', 10, '|||');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('This is a|||', $rs);
    }

    /**
     * @see \Tbs\Helper\String::truncate
     */
    public function testTruncate6()
    {
        $rs = string::truncate('This is to short string', 100);
        $this->assertInternalType('string', $rs);
        $this->assertEquals('This is to short string', $rs);
    }

    /**
     * @see \Tbs\Helper\String::lowerTrim()
     */
    public function testLowerTrim()
    {
        $rs = string::lowerTrim('   STRING    ');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('string', $rs);
    }

    /**
     * @see \Tbs\Helper\String::upperTrim()
     */
    public function testUpperTrim()
    {
        $rs = string::upperTrim('   string    ');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('STRING', $rs);
    }

    /**
     * @see \Tbs\Helper\String::capitalize()
     */
    public function testCapitalize()
    {
        $rs = string::capitalize('paRAleLEPIPedo');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('Paralelepipedo', $rs);
    }

    /**
     * @see \Tbs\Helper\String::oneSpaceOnly()
     */
    public function testOneSpaceOnly()
    {
        $rs = string::oneSpaceOnly('this    is       a      string   ');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('this is a string', $rs);
    }

    /**
     * @see \Tbs\Helper\String::StripSpaces()
     */
    public function testStripSpaces1()
    {
        $rs = string::stripSpaces('this is a string');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('this_is_a_string', $rs);
    }

    /**
     * @see \Tbs\Helper\String::StripSpaces()
     */
    public function testStripSpaces2()
    {
        $rs = string::stripSpaces('this is a string', '|');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('this|is|a|string', $rs);
    }

    /**
     * @see \Tbs\Helper\String::StripBreak()
     */
    public function testStripBreak()
    {
        $rs = string::stripBreak('
first line
seccond line
        ');
        $this->assertInternalType('string', $rs);
        $this->assertEquals('first lineseccond line', $rs);
    }

    /**
     * Provider of strings with accents.
     * @return array
     */
    public function providerStringsWithAccents()
    {
        return array
        (
            array('á', 'a'),
            array('Á', 'A'),
            array('à', 'a'),
            array('À', 'A'),
            array('â', 'a'),
            array('Â', 'A'),
            array('ã', 'a'),
            array('Ã', 'A'),
            array('ä', 'a'),
            array('Ä', 'A'),

            array('é', 'e'),
            array('É', 'E'),
            array('è', 'e'),
            array('È', 'E'),
            array('ê', 'e'),
            array('Ê', 'E'),
            array('ë', 'e'),
            array('Ë', 'E'),

            array('í', 'i'),
            array('Í', 'I'),
            array('ì', 'i'),
            array('Ì', 'I'),
            array('î', 'i'),
            array('Î', 'I'),
            array('ĩ', 'i'),
            array('Ĩ', 'I'),
            array('ï', 'i'),
            array('Ï', 'I'),

            array('ó', 'o'),
            array('Ó', 'O'),
            array('ò', 'o'),
            array('Ò', 'O'),
            array('ô', 'o'),
            array('Ô', 'O'),
            array('õ', 'o'),
            array('Õ', 'O'),
            array('ö', 'o'),
            array('Ö', 'O'),

            array('ú', 'u'),
            array('Ú', 'U'),
            array('ù', 'u'),
            array('Ù', 'U'),
            array('û', 'u'),
            array('Û', 'U'),
            array('ũ', 'u'),
            array('Ũ', 'U'),
            array('ü', 'u'),
            array('Ü', 'U'),

            array('ç', 'c'),
            array('Ç', 'C'),
        );
    }

    /**
     * @see \Tbs\Helper\String::stripAccents
     * @dataProvider providerStringsWithAccents
     */
    public function testStripAccents($string, $expected)
    {
        $rs = string::stripAccents($string);
        $this->assertInternalType('string', $rs);
        $this->assertEquals($expected, $rs);
    }
}
