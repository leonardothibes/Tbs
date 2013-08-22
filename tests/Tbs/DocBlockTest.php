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
    public function testOfClassException()
    {
        DocBlock::ofClass('');
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     */
    public function estOfPropertyWithClassName()
    {
        $rs = DocBlock::ofProperty('\Tbs\StuffClass', 'stuffProperty');
        $this->validateReturnOfClassess($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     */
    public function estOfPropertyWithClassInstance()
    {
        $class = new \Tbs\StuffClass();
        $rs    = DocBlock::ofClass($class);
        $this->validateReturnOfClassess($rs);
    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     */
    public function estOfPropertyExceptionClassBlank()
    {

    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     */
    public function estOfPropertyExceptionPropertyBlank()
    {

    }

    /**
     * @see \Tbs\DocBlock::ofProperty()
     */
    public function estOfPropertyNotExists()
    {

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
    public function testOfFunctionException()
    {
        DocBlock::ofFunction('');
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
     * Validate the return of functions and methods.
     * @param array $rs
     */
    private function validateReturnOfFunctionsAndMethods($rs)
    {
        $this->assertInstanceOf('\Tbs\DocBlock\Collection', $rs);
        $this->assertEquals('Short description.'         , $rs->getShortDescription());
        $this->assertEquals('This is a long description.', $rs->getLongDescription());

        $tags = $rs->getTags();
        $this->assertInternalType('array', $tags);
        $this->assertEquals(3, count($tags));
        $this->assertArrayHasKey('param' , $tags);
        $this->assertArrayHasKey('return', $tags);
        $this->assertArrayHasKey('throws', $tags);
    }
}
