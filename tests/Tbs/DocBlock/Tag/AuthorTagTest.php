<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;
use \Tbs\DocBlock\Tag\AuthorTag as A;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class AuthorTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Tag\AuthorTag
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
    public function providerWithEmail()
    {
        return array(
            array('@author name email@foo.com'),
            array('@author   name   email@foo.com  '),
            array('@author name <email@foo.com>'),
            array('@author   name   <email@foo.com>   '),
        );
    }

    /**
     * @see \Tbs\DocBlock\Tag\AuthorTag::parse()
     * @dataProvider providerWithEmail
     */
    public function testParseWithEmail($tag)
    {
        $rs = $this->object->parse($tag);
        $this->_testReturn($rs, true);
    }

    /**
     * Providers without description.
     * @return array
     */
    public function providerWithoutEmail()
    {
        return array(
            array('@author name'),
            array('@author   name   '),
        );
    }

    /**
     * @see \Tbs\DocBlock\Tag\AuthorTag::parse()
     * @dataProvider providerWithoutEmail
     */
    public function testParseWithoutEmail($tag)
    {
        $rs = $this->object->parse($tag);
        $this->_testReturn($rs, false);
    }

    /**
     * @see \Tbs\DocBlock\Tag\AuthorTag::parse()
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
        $this->assertEquals('author'       , $rs->getTag());
        $this->assertEquals(''             , $rs->getType());
        $this->assertEquals('name'         , $rs->getContent());
        if($desc === true) {
            $this->assertEquals('<email@foo.com>', $rs->getDescription());
        }
    }

    /**
     * @see \Tbs\DocBlock\Tag\Abstraction::export()
     * @dataProvider providerWithEmail
     */
    public function testExportWithEmail($tag)
    {
        $this->object->parse($tag);
        $rs = $this->object->export();
        $this->assertInternalType('string', $rs);
        $this->assertEquals('@author name <email@foo.com>', $rs);
        $this->assertEquals($rs, $this->object->__toString());
    }

    /**
     * @see \Tbs\DocBlock\Tag\Abstraction::export()
     * @dataProvider providerWithoutEmail
     */
    public function testExportWithoutEmail($tag)
    {
        $this->object->parse($tag);
        $rs = $this->object->export();
        $this->assertInternalType('string', $rs);
        $this->assertEquals('@author name', $rs);
        $this->assertEquals($rs, $this->object->__toString());
    }
}
