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
     * @param array $rs
     * @param bool  $desc
     */
    private function _testReturn($rs, $desc)
    {
        $this->assertInternalType('array', $rs);
        if($desc === true) {
            $this->assertEquals(4, count($rs));
        } else {
            $this->assertEquals(3, count($rs));
        }

        $this->assertArrayHasKey('tag', $rs);
        $this->assertEquals('param', $rs['tag']);

        $this->assertArrayHasKey('type', $rs);
        $this->assertEquals('string', $rs['type']);

        $this->assertArrayHasKey('content', $rs);
        $this->assertEquals('$variable', $rs['content']);

        if($desc === true) {
            $this->assertArrayHasKey('description', $rs);
            $this->assertEquals('description of the fucking param.', $rs['description']);
        }
    }
}
