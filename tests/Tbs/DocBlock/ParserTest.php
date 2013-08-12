<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock;
use \Tbs\DocBlock\Parser as P;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Parser
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
     * @see \Tbs\DocBlock\Parser::getParsed()
     */
    public function testGetParsedComplete()
    {
        $docBlock = '
            /**
             * This is an short description.
             *
             * This is an long description.
             *
             * @param string $first description of the param
             * @param string $seccond
             *
             * @return array This is a return of method
             */
        ';

        $rs = P::getParsed($docBlock);

        $this->assertInternalType('array', $rs);
        $this->assertEquals(3, count($rs));

        $this->assertArrayHasKey('shortDescription', $rs);
        $this->assertEquals('This is an short description.', $rs['shortDescription']);

        $this->assertArrayHasKey('longDescription', $rs);
        $this->assertEquals('This is an long description.', $rs['longDescription']);

        //print_r($rs['tags']);

        $this->assertArrayHasKey('tags', $rs);
        $this->assertInternalType('array', $rs['tags']);

        $this->assertInternalType('array', $rs['tags']);
        $this->assertEquals(2, count($rs['tags']));

        $this->assertArrayHasKey('param', $rs['tags']);
        $this->assertArrayHasKey('0', $rs['tags']['param']);

        /* $this->assertEquals(4, count($rs['tags']['param'][0]));
        $this->assertArrayHasKey('type', $rs['tags']['param'][0]);
        $this->assertArrayHasKey('name', $rs['tags']['param'][0]);
        $this->assertArrayHasKey('', $rs['tags']['param'][0]);
        $this->assertArrayHasKey('', $rs['tags']['param'][0]);

        $this->assertEquals(3, count($rs['tags']['param'][1]));
        $this->assertArrayHasKey('1', $rs['tags']['param']);

        $this->assertArrayHasKey('return', $rs['tags']); */
    }
}


























