<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;
use \Tbs\DocBlock\Tag\ReturnTag as R;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ReturnTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Tag\ReturnTag
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new R;
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
    public function providerWithDescription()
    {
        return array(
        	array('@return string description of the fucking return.'),
            array('@return    string   description    of    the    fucking   return.   '),
            array('@return string
                                description
                                of
                                the
                                fucking
                                return.
            '),
        );
    }

    /**
     * @see \Tbs\DocBlock\Tag\ReturnTag::parse()
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
            array('@return string'),
            array('@return    string   '),
            array('@return
                string
            '),
        );
    }

    /**
     * @see \Tbs\DocBlock\Tag\ReturnTag::parse()
     * @dataProvider providerWithoutDescription
     */
    public function testParseWithoutDescription($tag)
    {
        $rs = $this->object->parse($tag);
        $this->_testReturn($rs, false);
    }

    /**
     * @see \Tbs\DocBlock\Tag\ReturnTag::parse()
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
        $this->assertEquals('return'   , $rs->getTag());
        $this->assertEquals('string'   , $rs->getType());
        $this->assertEquals(''         , $rs->getContent());
        if($desc === true) {
            $this->assertEquals('description of the fucking return.', $rs->getDescription());
        }
    }

    /**
     * @see \Tbs\DocBlock\Tag\Abstraction::export()
     * @dataProvider providerWithDescription
     */
    public function testExportWithDescription($tag)
    {
        $this->object->parse($tag);
        $rs = $this->object->export();
        $this->assertInternalType('string', $rs);
        $this->assertEquals('@return string description of the fucking return.', $rs);
        $this->assertEquals($rs, $this->object->__toString());
    }

    /**
     * @see \Tbs\DocBlock\Tag\Abstraction::export()
     * @dataProvider providerWithoutDescription
     */
    public function testExportWithoutDescription($tag)
    {
        $this->object->parse($tag);
        $rs = $this->object->export();
        $this->assertInternalType('string', $rs);
        $this->assertEquals('@return string', $rs);
        $this->assertEquals($rs, $this->object->__toString());
    }
}
