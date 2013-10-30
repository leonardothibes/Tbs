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
        if (!defined('APPLICATION_PATH')) {
            define('APPLICATION_PATH', $this->applicationPath);
        }

        $this->applicationLogs = STUFF_PATH . '/../../../tmp/logs';
        if (!defined('APPLICATION_LOGS')) {
            define('APPLICATION_LOGS', $this->applicationLogs);
        }

        if (!defined('APPLICATION_LOG_PREFIX')) {
            define('APPLICATION_LOG_PREFIX', 'tbs');
        }

        if (!defined('APPLICATION_ENV')) {
            define('APPLICATION_ENV', $this->applicationEnv);
        }

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
     * @see \Tbs\ZfComponents\V1\Bootstrap::initApplicationConstants()
     */
    public function testInitApplicationConstants()
    {
        $this->assertEquals($this->applicationPath, Bootstrap::$applicationPath);
        $this->assertEquals(APPLICATION_PATH      , Bootstrap::$applicationPath);

        $this->assertEquals($this->applicationLogs, Bootstrap::$applicationLogs);
        $this->assertEquals(APPLICATION_LOGS      , Bootstrap::$applicationLogs);

        $this->assertEquals(APPLICATION_LOG_PREFIX, Bootstrap::$applicationLogPrefix);

        $this->assertEquals($this->applicationEnv, Bootstrap::$applicationEnv);
        $this->assertEquals(APPLICATION_ENV      , Bootstrap::$applicationEnv);

        $this->assertEquals('default', Bootstrap::$module);
        $this->assertEquals('UTF-8'  , Bootstrap::$charset);

        $this->assertEquals(Bootstrap::$viewHelpers, array(
            'ZendX_jQuery_View_Helper' => 'ZendX/jQuery/View/Helper'
        ));
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initFrontController()
     */
    public function testInitFrontController()
    {
        $frontController = \Zend_Controller_Front::getInstance();

        $defaultModule = $frontController->getDefaultModule();
        $this->assertEquals('default', $defaultModule);

        $controllers = $frontController->getControllerDirectory();
        $this->assertEquals(APPLICATION_PATH . '/default/controllers', $controllers[$defaultModule]);
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initIncludePath()
     */
    public function testInitIncludePath()
    {
        //Nothing to test.
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initLog()
     */
    public function testInitLog()
    {
        $expected = APPLICATION_LOGS . '/' . APPLICATION_LOG_PREFIX . '_' . date('Y-m-d') . '.log';
        $logfile  = \Tbs\Log::getInstance()->getLogger()->getLogFile();
        $this->assertEquals($expected, $logfile);
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initRoutes()
     */
    public function testInitRoutes()
    {
        $file = APPLICATION_PATH . '/configs/routes.ini';
        $this->assertTrue(file_exists($file));

        $routes = \Zend_Controller_Front::getInstance()->getRouter()->getRoutes();
        $this->assertInternalType('array', $routes);
        $this->assertArrayHasKey('route1', $routes);
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initConfigFile()
     */
    public function testInitConfigFile()
    {
        $file = APPLICATION_PATH . '/configs/config.ini';
        $this->assertTrue(file_exists($file));

        $config = \Zend_Registry::get('config');
        $this->assertInstanceOf('\\Zend_Config_Ini', $config);
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initDb()
     */
    public function testInitDb()
    {
        $db = \Zend_Registry::get('db');
        $this->assertInstanceOf('\\Zend_Db_Adapter_Pdo_Mysql', $db);
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initSessionNamespace()
     */
    public function testInitSessionNamespace()
    {
        //Nothing to test.
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initHeaders()
     */
    public function testInitHeaders()
    {
        //Nothing to test.
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initViewHelpers()
     */
    public function testInitViewHelpers()
    {
        $view = \Zend_Registry::get('view');
        $this->assertInstanceOf('\\Zend_View', $view);

        $encoding = $view->getEncoding();
        $this->assertEquals(strtolower(Bootstrap::$charset), $encoding);

        $helpers = $view->getHelperPaths();
        $this->assertInternalType('array', $helpers);
        $this->assertEquals(2, count($helpers));

        $this->assertArrayHasKey('Zend_View_Helper_', $helpers);
        $this->assertEquals('Zend/View/Helper/', $helpers['Zend_View_Helper_'][0]);

        $this->assertArrayHasKey('ZendX_jQuery_View_Helper_', $helpers);
        $this->assertEquals('ZendX/jQuery/View/Helper/', $helpers['ZendX_jQuery_View_Helper_'][0]);
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initViewLayout()
     */
    public function testInitViewLayout()
    {
        $layout = \Zend_Layout::getMvcInstance()->getLayout();
        $this->assertEquals('main', $layout);

        $layoutPath = \Zend_Layout::getMvcInstance()->getLayoutPath();
        $this->assertEquals(APPLICATION_PATH . '/default/views/layouts', $layoutPath);
    }

    /**
     * @see \Tbs\ZfComponents\V1\Bootstrap::initModuleBootstrap()
     */
    public function testInitModuleBootstrap()
    {
        //Nothing to test.
    }
}
