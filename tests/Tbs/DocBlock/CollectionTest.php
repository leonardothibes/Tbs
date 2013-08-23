<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\DocBlock;
use \Tbs\DocBlock\Collection;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class CollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\DocBlock\Collection
     */
    protected $object = null;

    /**
     * @var string
     */
    protected $shortDescription = 'This is an short description.';

    /**
     * @var string
     */
    protected $longDescription = 'This is an long description.';

    /**
     * @var string
     */
    protected $param1 = '@param string $first description of the param';

    /**
     * @var string
     */
    protected $param2 = '@param string $seccond';

    /**
     * @var string
     */
    protected $return = '@return array This is a return of method';

    /**
     * Setup.
     */
    protected function setUp()
    {
        $docBlock = $this->getDocBlock();
        $this->object = new Collection($docBlock);
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Get the test DocBlock.
     */
    private function getDocBlock()
    {
        return '
            /**
             * '.$this->shortDescription.'
             *
             * '.$this->longDescription.'
             *
             * '.$this->param1.'
             * '.$this->param2.'
             *
             * '.$this->return.'
             */
        ';
    }

    /**
     * Test if implements the right interface.
     */
    public function testInterface()
    {
        $this->assertInstanceOf('\Reflector' , $this->object);
    }
    /**
     * @see \Tbs\DocBlock\Parser::getParsed()
     * @expectedException \Tbs\DocBlock\Collection\Exception
     */
    public function testInstanceBlankDocBlock()
    {
        new Collection('');
    }

    /**
     * @see \Tbs\DocBlock\Collection::hasShortDescription()
     */
    public function testHasShortDescription()
    {
        $rs = $this->object->hasShortDescription();
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::hasShortDescription()
     */
    public function testHasNoShortDescription()
    {
        $docBlock = '
            /**
             * @param string $first description of the param
             * @param string $seccond
             *
             * @return array This is a return of method
             */
        ';
        $this->object = new Collection($docBlock);

        $rs = $this->object->hasShortDescription();
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::getShortDescription()
     */
    public function testGetShortDescription()
    {
        $rs = $this->object->getShortDescription();
        $this->assertEquals($this->shortDescription, $rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::getShortDescription()
     */
    public function testGetBlankShortDescription()
    {
        $docBlock = '
            /**
             * @param string $first description of the param
             * @param string $seccond
             *
             * @return array This is a return of method
             */
        ';
        $this->object = new Collection($docBlock);

        $rs = $this->object->getShortDescription();
        $this->assertNull($rs);
    }



    /**
     * @see \Tbs\DocBlock\Collection::hasLongDescription()
     */
    public function testHasLongDescription()
    {
        $rs = $this->object->hasLongDescription();
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::hasLongDescription()
     */
    public function testHasNoLongDescription()
    {
        $docBlock = '
            /**
             * @param string $first description of the param
             * @param string $seccond
             *
             * @return array This is a return of method
             */
        ';
        $this->object = new Collection($docBlock);

        $rs = $this->object->hasLongDescription();
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::getLongDescription()
     */
    public function testGetLongDescription()
    {
        $rs = $this->object->getLongDescription();
        $this->assertEquals($this->longDescription, $rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::getLongDescription()
     */
    public function testGetBlankLongDescription()
    {
        $docBlock = '
            /**
             * @param string $first description of the param
             * @param string $seccond
             *
             * @return array This is a return of method
             */
        ';
        $this->object = new Collection($docBlock);

        $rs = $this->object->getLongDescription();
        $this->assertNull($rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::getText()
     */
    public function testGetText()
    {
        $rs   = $this->object->getText();
        $text = $this->shortDescription . "\n\n" .
                $this->longDescription;
        $this->assertEquals($text, $rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::getText()
     */
    public function testGetBlankText()
    {
        $docBlock = '
            /**
             * @param string $first description of the param
             * @param string $seccond
             *
             * @return array This is a return of method
             */
        ';
        $this->object = new Collection($docBlock);

        $rs = $this->object->getText();
        $this->assertNull($rs);
    }

    /**
     * Provider os tags for hasTag test.
     * @return array
     */
    public function providerHasTag()
    {
        return array(
        	array('param' , true),
            array('return', true),
            array('other' , false),
        );
    }

    /**
     * @see \Tbs\DocBlock\Collection::hasTag()
     * @dataProvider providerHasTag
     */
    public function testHasTag($tag, $expected)
    {
        $rs = $this->object->hasTag($tag);
        $this->assertInternalType('bool', $rs);
        $this->assertEquals($expected, $rs);
    }

    /**
     * Provider os tags for getTag test.
     * @return array
     */
    public function providerGetTag()
    {
        return array(
            array('param' , 2),
            array('return', 1),
        );
    }

    /**
     * @see \Tbs\DocBlock\Collection::getTag()
     * @dataProvider providerGetTag
     */
    public function testGetTag($tagName, $qtd)
    {
        $rs = $this->object->getTag($tagName);

        $this->assertInternalType('array', $rs);
        $this->assertEquals($qtd, count($rs));

        foreach ($rs as $tag) {
            $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $tag);
            $this->assertEquals($tagName, $tag->getTag());
        }
    }

    /**
     * @see \Tbs\DocBlock\Collection::getTag()
     * @expectedException \Tbs\DocBlock\Collection\Exception
     */
    public function testGetTagNotExists()
    {
        $this->object->getTag('TagNotExists');
    }

    /**
     * @see \Tbs\DocBlock\Collection::hasTags()
     */
    public function testHasTagsTrue()
    {
        $rs = $this->object->hasTags();
        $this->assertTrue($rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::hasTags()
     */
    public function testHasTagsFalse()
    {
        $docBlock = '
            /**
             * '.$this->shortDescription.'
             *
             * '.$this->longDescription.'
             */
        ';
        $this->object = new Collection($docBlock);
        $rs = $this->object->hasTags();
        $this->assertFalse($rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::getTags()
     */
    public function testGetTags()
    {
        $rs = $this->object->getTags();

        $this->assertInternalType('array', $rs);
        $this->assertEquals(2, count($rs));

        foreach ($rs as $tag) {
            $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $tag[0]);
        }
    }

    /**
     * @see \Tbs\DocBlock\Collection::getTags()
     */
    public function testGetBlankTags()
    {
        $docBlock = '
            /**
             * '.$this->shortDescription.'
             *
             * '.$this->longDescription.'
             */
        ';
        $this->object = new Collection($docBlock);
        $rs = $this->object->getTags();
        $this->assertNull($rs);
    }

    /**
     * @see \Tbs\DocBlock\Collection::export()
     */
    public function test__toString()
    {
        $docBlock = $this->object->__toString();
        $rs       = \Tbs\DocBlock\Parser::getParsed($docBlock);

        $this->assertInternalType('array', $rs);
        $this->assertEquals(3, count($rs));

        $this->assertArrayHasKey('shortDescription', $rs);
        $this->assertArrayHasKey('longDescription', $rs);
        $this->assertArrayHasKey('tags', $rs);

        $tags = $rs['tags'];

        $this->assertInternalType('array', $tags);
        $this->assertEquals(2, count($tags));

        $this->assertArrayHasKey('param', $tags);
        $this->assertArrayHasKey('return', $tags);

        foreach ($tags as $tag) {
            $this->assertInstanceOf('\Tbs\DocBlock\Collection\Parsed', $tag[0]);
        }
    }
}
