<?php
/**
 * @package Tests\Tbs\Client
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;
use \Tbs\Client;
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @package Tests\Tbs\Client
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Tbs\Client
     */
    protected $object = null;

    /**
     * @see \Tbs\Client::getIp()
     */
    public function testGetIp()
    {
        $rs = Client::getIp();
        $this->assertInternalType('string', $rs);
        $this->assertEquals('127.0.0.1', $rs);
    }
}















