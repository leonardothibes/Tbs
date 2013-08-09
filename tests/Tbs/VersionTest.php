<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Version
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;
use \Tbs\Version as v;

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Version
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Version
     */
    protected $object = null;

    /**
     * Setup.
     */
    public function setUp()
    {
    	$this->object = new \Tbs\Version();
    }

    /**
     * TearDown.
     */
    public function tearDown()
    {
    	unset($this->object);
    }

    /**
     * @see \Tbs\Version::getDefaultFileLocation()
     */
    public function testGetDefaultFileLocation()
    {
        $rs = v::getDefaultFileLocation();
        $this->assertInternalType('string', $rs);
        $this->assertTrue(file_exists($rs));
    }

    /**
     * @see \Tbs\Version::get()
     */
    public function testGetWithDefualtFileLocation()
    {
        $rs = v::get();
        $this->assertInternalType('string', $rs);

        $version = file_get_contents(LIBRARY_PATH . '/Tbs/Version/Number.txt');
        $this->assertEquals($version, $rs);
    }

    /**
     * @see \Tbs\Version::get()
     */
    public function testGetNoDefaultFileLocation()
    {
        $fl = v::getDefaultFileLocation();
        $rs = v::get($fl);

        $version = file_get_contents(LIBRARY_PATH . '/Tbs/Version/Number.txt');
        $this->assertEquals($version, $rs);
    }

    /**
     * @see \Tbs\Version::get()
     * @expectedException \Tbs\Version\Exception
     */
    public function testGetException()
    {
       	v::get('/tmp/sbrubles.txt');
    }
}
