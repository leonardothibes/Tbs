<?php
/**
 * @package Tbs\ZfComponents\V1
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1;
use \Tbs\ZfComponents\V1\Bootstrap;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';
require_once 'Zend/Application.php';
require_once 'Zend/Config/Ini.php';

/**
 * @package Tbs\ZfComponents\V1
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $applicationPath = null;

    /**
     * @var string
     */
    protected $applicationLogs = null;

    /**
     * @var string
     */
    protected $applicationEnv = 'development';

    /**
     * Setup.
     */
    protected function setUp()
    {
        $this->applicationPath = STUFF_PATH . '/zf/application';
        define('APPLICATION_PATH', $this->applicationPath);

        $this->applicationLogs = STUFF_PATH . '/../../../tmp/logs';
        define('APPLICATION_LOGS', $this->applicationLogs);

        define('APPLICATION_ENV'       , $this->applicationEnv);
        define('APPLICATION_LOG_PREFIX', 'tbs');

        $application = new \Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        $application->bootstrap();
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
        $this->applicationPath = null;
        $this->applicationLogs = null;
    }

    /**
     * Verifying the initial values of properties.
     */
    public function testInitialValues()
    {
        \Tbs\Log::debug(Bootstrap::$applicationEnv);
    }
}






















