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
    public function testGetParsed()
    {
        $docBlock = '
            /**
             * This is an short description.
             *
             * This is an long description.
             *
             * @param string $first
             * @param string $seccond
             *
             * @return array
             */
        ';

        $rs = P::getParsed($docBlock);

        var_dump($rs);

        $this->assertInternalType('array', $rs);
        $this->assertEquals(3, count($rs));

        $this->assertArrayHasKey('shortDescription', $rs);
        $this->assertEquals('This is an short description.', $rs['shortDescription']);

        $this->assertArrayHasKey('longDescription', $rs);
        $this->assertEquals('This is an long description.', $rs['longDescription']);

        $this->assertArrayHasKey('tags', $rs);
        $this->assertInternalType('array', $rs['tags']);
    }
}


























