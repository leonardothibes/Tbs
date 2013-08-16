<?php
/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\Helper;
use \Tbs\Log\LogLevel;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Tbs
 * @subpackage Helper
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class LogLevelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @see \Tbs\Log\LogLevel::EMERGENCY
     */
    public function testEmergency()
    {
        $this->assertEquals('emergency', LogLevel::EMERGENCY);
    }

    /**
     * @see \Tbs\Log\LogLevel::ALERT
     */
    public function testAlert()
    {
        $this->assertEquals('alert', LogLevel::ALERT);
    }

    /**
     * @see \Tbs\Log\LogLevel::CRITICAL
     */
    public function testCritical()
    {
        $this->assertEquals('critical', LogLevel::CRITICAL);
    }

    /**
     * @see \Tbs\Log\LogLevel::ERROR
     */
    public function testError()
    {
        $this->assertEquals('error', LogLevel::ERROR);
    }

    /**
     * @see \Tbs\Log\LogLevel::WARNING
     */
    public function testWarning()
    {
        $this->assertEquals('warning', LogLevel::WARNING);
    }

    /**
     * @see \Tbs\Log\LogLevel::NOTICE
     */
    public function testNotice()
    {
        $this->assertEquals('notice', LogLevel::NOTICE);
    }

    /**
     * @see \Tbs\Log\LogLevel::INFO
     */
    public function testInfo()
    {
        $this->assertEquals('info', LogLevel::INFO);
    }

    /**
     * @see \Tbs\Log\LogLevel::DEBUG
     */
    public function testDebug()
    {
        $this->assertEquals('debug', LogLevel::DEBUG);
    }
}
