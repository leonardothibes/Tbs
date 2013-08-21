<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;
use \Tbs\DocBlock\Tag\PackageTag as A;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class PackageTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Tag\PackageTag
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new A;
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
    public function providerPkg()
    {
        return array(
            array('@package PSR'                  , 'PSR'),
            array('@package PSR\Documentation'    , 'PSR\Documentation'),
            array('@package PSR\Documentation\API', 'PSR\Documentation\API'),
        );
    }

    /**
     * @see \Tbs\DocBlock\Tag\PackageTag::parse()
     * @dataProvider providerPkg
     */
    public function testParse($tag, $expected)
    {
        $rs = $this->object->parse($tag);
        $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $rs);

        $this->assertEquals('package', $rs->getTag());
        $this->assertEquals($expected, $rs->getContent());
    }

    /**
     * @see \Tbs\DocBlock\Tag\PackageTag::parse()
     * @expectedException \Tbs\DocBlock\Tag\Exception
     */
    public function testParseException()
    {
        $this->object->parse('');
    }

    /**
     * @see \Tbs\DocBlock\Tag\Abstraction::export()
     * @dataProvider providerPkg
     */
    public function testExport($tag, $expected)
    {
        $this->object->parse($tag);
        $rs = $this->object->export();
        $this->assertInternalType('string', $rs);
        $this->assertEquals('@package ' . $expected, $rs);
        $this->assertEquals($rs, $this->object->__toString());
    }
}
