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

	public function testGet()
	{
		$rs = v::get();
		$this->assertInternalType('string', $rs);

		$version = file_get_contents(LIBRARY_PATH . '/Tbs/Version/Number.txt');
		$this->assertEquals($version, $rs);
	}
}
