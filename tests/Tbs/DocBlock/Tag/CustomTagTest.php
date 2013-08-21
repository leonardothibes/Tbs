<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;
use \Tbs\DocBlock\Tag\CustomTag as C;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class CustomTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Tag\CustomTag
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new C;
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
        $this->assertInstanceOf('\Tbs\DocBlock\Tag\Abstraction' , $this->object);
        $this->assertInstanceOf('\Tbs\DocBlock\Tag\InterfaceTag', $this->object);
    }

    /**
     * Providers with description.
     * @return array
     */
    public function providerTags()
    {
        return array(
            array('custom'      , '@custom CustomContent'                , 'CustomContent'),
            array('dataSource'  , '@dataSource \Models\Client'           , '\Models\Client'),
            array('dataProvider', '@dataProvider providerOfCustomContent', 'providerOfCustomContent'),
        );
    }

    /**
     * @see \Tbs\DocBlock\Tag\CustomTag::parse()
     * @dataProvider providerTags
     */
    public function testParse($tag, $line, $expected)
    {
        $rs = $this->object->parse($line);
        $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $rs);

        $this->assertEquals($tag, $rs->getTag());
        $this->assertEquals($expected, $rs->getContent());
    }

    /**
     * @see \Tbs\DocBlock\Tag\CustomTag::parse()
     * @expectedException \Tbs\DocBlock\Tag\Exception
     */
    public function testParseException()
    {
        $this->object->parse('');
    }

    /**
     * @see \Tbs\DocBlock\Tag\Abstraction::export()
     * @dataProvider providerTags
     */
    public function testExport($tag, $line, $expected)
    {
        $this->object->parse($line);
        $rs = $this->object->export();
        $this->assertInternalType('string', $rs);
        $this->assertEquals('@' . $tag . ' ' . $expected, $rs);
        $this->assertEquals($rs, $this->object->__toString());
    }
}
