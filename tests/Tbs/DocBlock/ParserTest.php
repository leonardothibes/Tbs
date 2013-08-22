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
        $this->validateReturn($rs);
        $this->validateShortDescrption($rs);
        $this->validateLongDescrption($rs);
        $this->validateTags($rs['tags']);
    }

    /**
     * Validate return.
     *
     * @param  array $rs
     * @return void
     */
    private function validateReturn($rs)
    {
        $this->assertInternalType('array', $rs);
        $this->assertEquals(3, count($rs));
        $this->assertArrayHasKey('shortDescription', $rs);
        $this->assertArrayHasKey('longDescription', $rs);
        $this->assertArrayHasKey('tags', $rs);
    }

    /**
     * Validate a short description.
     *
     * @param  array $rs
     * @return void
     */
    private function validateShortDescrption($rs)
    {
        $this->assertArrayHasKey('shortDescription', $rs);
        $this->assertEquals('This is an short description.', $rs['shortDescription']);
    }

    /**
     * Validate a long description.
     *
     * @param  array $rs
     * @return void
     */
    private function validateLongDescrption($rs)
    {
        $this->assertArrayHasKey('longDescription', $rs);
        $this->assertEquals('This is an long description.', $rs['longDescription']);
    }

    /**
     * Validate tags.
     *
     * @param  array $rs
     * @return void
     */
    private function validateTags($rs)
    {
        $this->assertInternalType('array', $rs);
        $this->assertEquals(2, count($rs));

        $this->assertArrayHasKey('param', $rs);
        $this->validateParamTag($rs['param']);

        $this->assertArrayHasKey('return', $rs);
        $this->validateReturnTag($rs['return']);
    }

    /**
     * Validate param tag.
     *
     * @param  array $tags
     * @return void
     */
    private function validateParamTag($tags)
    {
        foreach ($tags as $tag) {
            $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $tag);
            $this->assertEquals('param' , $tag->getTag());
            $this->assertEquals('string', $tag->getType());
            $this->assertRegExp('/^\$[a-z]{1,100}$/', $tag->getContent());
            $description = $tag->getDescription();
            if (strlen($description)) {
                $this->assertEquals('description of the param', $description);
            }
        }
    }

    /**
     * Validate return tag.
     *
     * @param  array $tags
     * @return void
     */
    private function validateReturnTag($tags)
    {
        foreach ($tags as $tag) {
            $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $tag);
            $this->assertEquals('return' , $tag->getTag());
            $this->assertEquals('array'  , $tag->getType());
            $description = $tag->getDescription();
            if (strlen($description)) {
                $this->assertEquals('This is a return of method', $description);
            }
        }
    }

    /**
     * Validate custom tag.
     *
     * @param  array $tags
     * @return void
     */
    private function validateCustomTag($tags)
    {
        foreach ($tags as $tag) {
            $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $tag);
            $this->assertEquals('customTag'            , $tag->getTag());
            $this->assertEquals('ThisIsACustomTagValue', $tag->getContent());
            $description = $tag->getDescription();
            if (strlen($description)) {
                $this->assertEquals('This is a return of method', $description);
            }
        }
    }

    /**
     * @see \Tbs\DocBlock\Parser::getParsed()
     */
    public function testGetParsedShortDescription()
    {
        $docBlock = '
            /**
             * This is an short description.
             */
        ';

        $rs = P::getParsed($docBlock);
        $this->validateReturn($rs);
        $this->validateShortDescrption($rs);
    }

    /**
     * @see \Tbs\DocBlock\Parser::getParsed()
     */
    public function testGetParsedLongDescription()
    {
        $docBlock = '
            /**
             * This is an short description.
             *
             * This is an long description.
             */
        ';

        $rs = P::getParsed($docBlock);
        $this->validateReturn($rs);
        $this->validateLongDescrption($rs);
    }

    /**
     * @see \Tbs\DocBlock\Parser::getParsed()
     */
    public function testGetParsedNoDescription()
    {
        $docBlock = '
            /**
             * @param string $first description of the param
             * @param string $seccond
             *
             * @return array This is a return of method
             */
        ';

        $rs = P::getParsed($docBlock);
        $this->validateReturn($rs);
        $this->validateTags($rs['tags']);
    }

    /**
     * @see \Tbs\DocBlock\Parser::getParsed()
     */
    public function testGetParsedCustomTags()
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
             * @customTag ThisIsACustomTagValue
             */
        ';

        $rs = P::getParsed($docBlock);

        $this->validateReturn($rs);
        $this->validateShortDescrption($rs);
        $this->validateLongDescrption($rs);

        $tags = $rs['tags'];

        $this->assertInternalType('array', $tags);
        $this->assertEquals(3, count($tags));

        $this->assertArrayHasKey('param', $tags);
        $this->validateParamTag($tags['param']);

        $this->assertArrayHasKey('return', $tags);
        $this->validateReturnTag($tags['return']);

        $this->assertArrayHasKey('customTag', $tags);
        $this->validateCustomTag($tags['customTag']);
    }
}
