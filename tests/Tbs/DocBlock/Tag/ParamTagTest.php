<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;
use \Tbs\DocBlock\Tag\ParamTag as P;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ParamTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Tag\ParamTag
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
     * Test if implements the right interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf('\Tbs\DocBlock\Tag\Abstraction' , $this->object);
        $this->assertInstanceOf('\Tbs\DocBlock\Tag\InterfaceTag', $this->object);
        $this->assertInstanceOf('\Reflector'                    , $this->object);
    }

    /**
     * Providers with description.
     * @return array
     */
    public function providerWithDescription()
    {
        return array(
        	array('@param string $variable description of the fucking param.'),
            array('@param    string    $variable   description   of   the   fucking   param.   '),
            array('@param string $variable description
                                           of
                                           the
                                           fucking
                                           param.'),
        );
    }

    /**
     * @see \Tbs\DocBlock\Tag\ParamTag::parse()
     * @dataProvider providerWithDescription
     */
    public function testParseWithDescription($tag)
    {
        $rs = $this->object->parse($tag);
        $this->_testReturn($rs, true);
    }

    /**
     * Providers without description.
     * @return array
     */
    public function providerWithoutDescription()
    {
        return array(
            array('@param string $variable'),
            array('@param    string    $variable   '),
            array('@param string $variable '),
        );
    }

    /**
     * @see \Tbs\DocBlock\Tag\ParamTag::parse()
     * @dataProvider providerWithoutDescription
     */
    public function testParseWithoutDescription($tag)
    {
        $rs = $this->object->parse($tag);
        $this->_testReturn($rs, false);
    }

    /**
     * @see \Tbs\DocBlock\Tag\ParamTag::parse()
     * @expectedException \Tbs\DocBlock\Tag\Exception
     */
    public function testParseException()
    {
        $this->object->parse('');
    }

    /**
     * Test param return.
     *
     * @param \Tbs\DocBlock\Collection\Parsed $rs
     * @param bool                            $desc
     */
    private function _testReturn($rs, $desc)
    {
        $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $rs);
        $this->assertEquals('param'    , $rs->getTag());
        $this->assertEquals('string'   , $rs->getType());
        $this->assertEquals('$variable', $rs->getContent());
        if($desc === true) {
            $this->assertEquals('description of the fucking param.', $rs->getDescription());
        }
    }
}
