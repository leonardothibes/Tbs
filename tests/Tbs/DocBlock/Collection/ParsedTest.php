<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;
use \Tbs\DocBlock\Collection\Parsed as P;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ParsedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Collection\Parsed
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new P;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Provider of tags.
     * @return array
     */
    public function providerTags()
    {
        return array(
        	array('param'       , 'param'),
            array('@param'      , 'param'),
            array('   param   ' , 'param'),
            array('   @param   ', 'param'),

            array('return'       , 'return'),
            array('@return'      , 'return'),
            array('   return   ' , 'return'),
            array('   @return   ', 'return'),
        );
    }

    /**
     * @see \Tbs\DocBlock\Collection\Parsed::setTag()
     * @dataProvider providerTags
     */
    public function testSetTag($tag, $expected)
    {
        $rs = $this->object->setTag($tag);
        $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $rs);

        $rs = $this->object->getTag();
        $this->assertInternalType('string', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * Provider of types.
     * @return array
     */
    public function providerTypes()
    {
        return array(
        	array('string'),
            array('   string   '),

            array('array'),
            array('   array   '),

            array('integer'),
            array('   integer   '),

            array('int'),
            array('   int   '),

            array('boolean'),
            array('   boolean   '),

            array('bool'),
            array('   bool   '),

            array('object'),
            array('   object   '),

            array('Foo'),
            array('   Foo   '),

            array('Bar'),
            array('   Bar   '),
        );
    }

    /**
     * @see \Tbs\DocBlock\Collection\Parsed::setType()
     * @dataProvider providerTypes
     */
    public function testSetType($type)
    {
        $rs = $this->object->setType($type);
        $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $rs);

        $rs = $this->object->getType();
        $this->assertInternalType('string', $rs);
        $this->assertEquals(trim($type), $rs);
    }

    /**
     * Provider of contents.
     * @return array
     */
    public function providerContent()
    {
        return array(
        	array('$variableName'),
            array('   $variableName   '),
        );
    }

    /**
     * @see \Tbs\DocBlock\Collection\Parsed::setContent()
     * @dataProvider providerContent
     */
    public function testSetContent($content)
    {
        $rs = $this->object->setContent($content);
        $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $rs);

        $rs = $this->object->getContent();
        $this->assertInternalType('string', $rs);
        $this->assertEquals(trim($content), $rs);
    }

    /**
     * Provider of descriptions.
     * @return array
     */
    public function providerDescription()
    {
        return array(
        	array('this is a description of tag'),
            array('   this is a description of tag   '),
        );
    }

    /**
     * @see \Tbs\DocBlock\Collection\Parsed::setDescription()
     * @dataProvider providerDescription
     */
    public function testSetDescription($description)
    {
        $rs = $this->object->setDescription($description);
        $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $rs);

        $rs = $this->object->getDescription();
        $this->assertInternalType('string', $rs);
        $this->assertEquals(trim($description), $rs);
    }

    /**
     * @see \Tbs\DocBlock\Tag\Abstraction::export()
     */
    public function testExport()
    {
        $this->object->setTag('param')
                     ->setType('string')
                     ->setContent('$name')
                     ->setDescription('This is description of param.');
        $rs = $this->object->export();
        $this->assertInternalType('string', $rs);
        $this->assertEquals('@param string $name This is description of param.', $rs);
    }
}
