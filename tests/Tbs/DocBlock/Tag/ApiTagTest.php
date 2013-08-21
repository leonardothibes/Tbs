<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock\Tag;
use \Tbs\DocBlock\Tag\ApiTag as A;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ApiTagTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Tag\ApiTag
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
     * @see \Tbs\DocBlock\Tag\ApiTag::parse()
     */
    public function testParse()
    {
        $rs = $this->object->parse('@api');
        $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $rs);
    }

    /**
     * @see \Tbs\DocBlock\Tag\ApiTag::parse()
     * @expectedException \Tbs\DocBlock\Tag\Exception
     */
    public function testParseExceptionBlank()
    {
        $this->object->parse('');
    }

    /**
     * @see \Tbs\DocBlock\Tag\ApiTag::parse()
     * @expectedException \Tbs\DocBlock\Tag\Exception
     */
    public function testParseExceptionOther()
    {
        $this->object->parse('@see');
    }
}
