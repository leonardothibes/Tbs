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
     * @var \Tbs\DocBlock
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {

    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {

    }

    /**
     * @see \Tbs\DocBlock::ofFunction()
     */
    public function testOfFunction()
    {
        require_once STUFF_PATH . '/DocBlock/StuffFunction.php';
        $rs = DocBlock::ofFunction('\Tbs\stuffFunction');
        $this->validateReturnOfFunctionsAndMethods($rs);
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
