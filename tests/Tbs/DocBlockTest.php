<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;

use \Tbs\DocBlock;

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Bootstrap.php';
require_once STUFF_PATH . '/DocBlock/StuffClass.php';
require_once STUFF_PATH . '/DocBlock/StuffFunction.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DockBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class DocBlockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @see \Tbs\DocBlock::ofClass()
     */
    public function testOfClassWithClassName()
    {
        $rs = DocBlock::ofClass('\Tbs\StuffClass');
        $this->validateReturnOfClassess($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofClass()
     */
    public function testOfClassWithClassInstance()
    {
        $class = new \Tbs\StuffClass();
        $rs    = DocBlock::ofClass($class);
        $this->validateReturnOfClassess($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofClass()
     * @expectedException \Tbs\DocBlock\Exception
     */
    public function testOfClassNotExists()
    {
        DocBlock::ofClass('\Tbs\NotExistsClass');
    }

    /**
     * @see \Tbs\DocBlock::ofClass()
     * @expectedException \Tbs\DocBlock\Exception
     */
    public function testOfClassNotExistsWithAutoloderOff()
    {
    	DocBlock::ofClass('\Tbs\NotExistsClass');
    }

    /**
     * @see \Tbs\DocBlock::ofClass()
     * @expectedException \Tbs\DocBlock\Exception
     */
    public function testOfClassBlank()
    {
        DocBlock::ofClass('');
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     */
    public function testOfPropertyWithClassName()
    {
        $rs = DocBlock::ofProperty('\Tbs\StuffClass', 'stuffProperty');
        $this->validadeProperty($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     */
    public function testOfPropertyWithClassInstance()
    {
        $class = new \Tbs\StuffClass();
        $rs    = DocBlock::ofProperty($class, 'stuffProperty');
        $this->validadeProperty($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfPropertyExceptionClassBlank()
    {
    	DocBlock::ofProperty('', 'stuffProperty');
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfPropertyExceptionPropertyBlank()
    {
    	DocBlock::ofProperty('\Tbs\StuffClass', '');
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfPropertyExceptionPropertyAndClassBlank()
    {
    	DocBlock::ofProperty('', '');
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfPropertyNotExists()
    {
    	DocBlock::ofProperty('\Tbs\StuffClass', 'PropertyNotExists');
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfPropertyClassNotExists()
    {
    	DocBlock::ofProperty('\Tbs\ClassNotExists', 'stuffProperty');
    }

    /**
     * @see \Tbs\DocBlock::ofMethod()
     */
    public function testOfMethodWithClassName()
    {
    	$rs = DocBlock::ofMethod('\Tbs\StuffClass', 'stuffMethod');
    	$this->validateReturnOfFunctionsAndMethods($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofMethod()
     */
    public function testOfMethodWithClassInstance()
    {
    	$class = new \Tbs\StuffClass();
    	$rs    = DocBlock::ofMethod($class, 'stuffMethod');
    	$this->validateReturnOfFunctionsAndMethods($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofMethod()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfMethodExceptionClassBlank()
    {
    	DocBlock::ofMethod('', 'stuffMethod');
    }

    /**
     * @see \Tbs\DocBlock::ofMethod()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfMethodExceptionMethodBlank()
    {
    	DocBlock::ofMethod('\Tbs\StuffClass', '');
    }

    /**
     * @see \Tbs\DocBlock::ofMethod()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfMethodExceptionMethodAndClassBlank()
    {
    	DocBlock::ofMethod('', '');
    }

    /**
     * @see \Tbs\DocBlock::ofMethod()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfMethodNotExists()
    {
    	DocBlock::ofMethod('\Tbs\StuffClass', 'MethodNotExists');
    }

    /**
     * @see \Tbs\DocBlock::ofMethod()
     * @expectedException Tbs\DocBlock\Exception
     */
    public function testOfMethodClassNotExists()
    {
    	DocBlock::ofMethod('\Tbs\ClassNotExists', 'stuffMethod');
    }

    /**
     * @see \Tbs\DocBlock::ofFunction()
     */
    public function testOfFunction()
    {
    	$rs = DocBlock::ofFunction('\Tbs\stuffFunction');
    	$this->validateReturnOfFunctionsAndMethods($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofFunction()
     * @expectedException \Tbs\DocBlock\Exception
     */
    public function testOfFunctionBlank()
    {
        DocBlock::ofFunction('');
    }

    /**
     * @see \Tbs\DocBlock::ofFunction()
     * @expectedException \Tbs\DocBlock\Exception
     */
    public function testOfFunctionNotExists()
    {
    	DocBlock::ofFunction('NotExistsFunction');
    }

    /**
     * Validate the return of classes.
     * @param array $rs
     */
    private function validateReturnOfClassess($rs)
    {
        $this->assertInstanceOf('\Tbs\DocBlock\Collection', $rs);
        $this->assertEquals('Short description.'         , $rs->getShortDescription());
        $this->assertEquals('This is a long description.', $rs->getLongDescription());

        $tags = $rs->getTags();
        $this->assertInternalType('array', $tags);
        $this->assertEquals(5, count($tags));
        $this->assertArrayHasKey('category' , $tags);
        $this->assertArrayHasKey('package' , $tags);
        $this->assertArrayHasKey('subpackage' , $tags);
        $this->assertArrayHasKey('author' , $tags);
        $this->assertArrayHasKey('copyright' , $tags);
    }

    /**
     * Validate the return of properties.
     * @param mixed $rs
     */
    private function validadeProperty($rs)
    {
		$this->assertInstanceOf('\Tbs\DocBlock\Collection', $rs);
		$this->assertEquals('Stuff property.', $rs->getShortDescription());
		$this->assertNull($rs->getLongDescription());

		$tags = $rs->getTags();
		$this->assertInternalType('array', $tags);
		$this->assertEquals(1, count($tags));
		$this->assertArrayHasKey('var' , $tags);
    }

    /**
     * Validate the return of functions and methods.
     * @param array $rs
     */
    private function validateReturnOfFunctionsAndMethods($rs)
    {
        $this->assertInstanceOf('\Tbs\DocBlock\Collection', $rs);
        $this->assertEquals('Short description.'          , $rs->getShortDescription());
        $this->assertEquals('This is a long description.' , $rs->getLongDescription());

        $tags = $rs->getTags();
        $this->assertInternalType('array', $tags);
        $this->assertEquals(3, count($tags));
        $this->assertArrayHasKey('param' , $tags);
        $this->assertArrayHasKey('return', $tags);
        $this->assertArrayHasKey('throws', $tags);
    }
}
