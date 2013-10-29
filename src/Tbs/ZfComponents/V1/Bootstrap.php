<?php
/**
 * @package Tbs\ZfComponents\V1
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1;

use \Tbs\ZfComponents\V1\Bootstrap\Abstraction as A;

/**
 * Bootstrap class for ZF1 modules.
 *
 * @package Tbs\ZfComponents\V1
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Bootstrap extends A
{
    /**
     * Application path of ZF1 modules.
     * @var string
     */
    public static $applicationPath = null;

    /**
     * Application log path.
     * @var string
     */
    public static $applicationLogs = null;

    /**
     * Log file prefix of name.
     * @var string
     */
    public static $applicationLogPrefix = 'application';

    /**
     * Application environment.
     * @var string
     */
    public static $applicationEnv = 'development';

    /**
     * Current module name.
     * @var string
     */
    public static $module = 'default';

    /**
     * View helpers list.
     * @var array
     */
    public static $viewHelpers = array(
        'ZendX_jQuery_View_Helper' => 'ZendX/jQuery/View/Helper',
    );

    /**
     * Charset.
     * @var string
     */
    public static $charset = 'UTF-8';

    /**
     * Initting the application constants environment.
     */
    public static function initApplicationConstants()
    {
        if (!defined('APPLICATION_ENV')) {
            throw new \Tbs\ZfComponents\V1\Bootstrap\Exception(
                'The constant "APPLICATION_ENV" is not defined'
            );
        }
        self::$applicationEnv = APPLICATION_ENV;

        if (!defined('APPLICATION_PATH')) {
            throw new \Tbs\ZfComponents\V1\Bootstrap\Exception(
                'The constant "APPLICATION_PATH" is not defined'
            );
        }
        self::$applicationPath = APPLICATION_PATH;

        if (!defined('APPLICATION_LOGS')) {
            throw new \Tbs\ZfComponents\V1\Bootstrap\Exception(
                'The constant "APPLICATION_LOGS" is not defined'
            );
        }
        self::$applicationLogs = APPLICATION_LOGS;

        if (defined('APPLICATION_LOG_PREFIX')) {
            self::$applicationLogPrefix = APPLICATION_LOG_PREFIX;
        }
    }

    /**
     * Setting class loader to ON.
     */
    public static function initClassLoader()
    {
        /** @see \Zend_Loader_Autoloader **/
        require_once 'Zend/Loader/Autoloader.php';
        \Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
    }

    /**
     * Loading the modules in front controller.
     */
    public static function initFrontController()
    {
        $frontController = \Zend_Controller_Front::getInstance();
        $frontController->setDefaultModule(self::$module);

        $directoryiterator = new \DirectoryIterator(self::$applicationPath);
        $request           = new \Zend_Controller_Request_Http();

        foreach ($directoryiterator as $directory) {

            $name = $directory->getBaseName();
            if ($directory->isDir() and substr($name, 0, 1) != '.' and $name != 'configs') {

                //Adding the controllers directory.
                $controllers = sprintf('%s/%s/controllers', self::$applicationPath, $name);
                $frontController->addControllerDirectory($controllers, $name);

                //Setting the current module name.
                $route = new \Zend_Controller_Router_Route_Regex(sprintf('/%s/*', $name));
                if (is_array($route->match($request->getRequestUri(), true))) {
                    self::$module = $name;
                }
            }
        }
    }

    /**
     * Adding the current module directories in include_path.
     */
    public static function initIncludePath()
    {
        $path = array(get_include_path(),
            sprintf('%s/%s/models', self::$applicationPath, self::$module),
            sprintf('%s/%s/forms', self::$applicationPath, self::$module),
            sprintf('%s/%s/controllers', self::$applicationPath, self::$module),
        );
        set_include_path(implode(PATH_SEPARATOR, $path));
    }

    /**
     * Initing the log classes.
     */
    public static function initLog()
    {
        try {
            if (!is_dir(self::$applicationLogs) or !is_writable(self::$applicationLogs)) {
                $message = sprintf('The log directory "%s" not exists or is not writable', self::$applicationLogs);
                throw new \Tbs\ZfComponents\V1\Bootstrap\Exception($message);
            }

            $logfile = sprintf('%s/%s_%s.log', self::$applicationLogs, self::$applicationLogPrefix, date('Y-m-d'));
            \Tbs\Log::getInstance()->setLogger(
                new \Tbs\Log\File($logfile)
            );
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Loading Zend Routes.
     */
    public static function initRoutes()
    {
        try {
            $routes = sprintf('%s/configs/routes.ini', self::$applicationPath);
            $router = \Zend_Controller_Front::getInstance()->getRouter();
            $router->addConfig(new \Zend_Config_Ini($routes), 'routes');
        } catch (\Exception $e) {
            //Nothing to do...
        }
    }

    /**
     * Loading config file.
     */
    public static function initConfigFile()
    {
        $file    = sprintf('%s/configs/config.ini', self::$applicationPath);
        $options = (self::$applicationEnv === 'testing') ? array('allowModifications' => true) : array();
        $config  = new \Zend_Config_Ini($file, self::$applicationEnv, $options);
        \Zend_Registry::set('config', $config);
    }

    /**
     * Connecting the database, when applicable.
     */
    public static function initDb()
    {
        if (\Zend_Registry::isRegistered('config')) {
            $config = \Zend_Registry::get('config')->db;
            $params = array(
                'host'     => $config->hostname,
                'username' => $config->username,
                'password' => $config->password,
                'dbname'   => $config->dbname,
                'pdoType'  => (strtoupper($config->adapter) == 'PDO_MSSQL') ? 'dblib' : null
            );
            $db = \Zend_Db::factory($config->adapter, $params);
            \Zend_Registry::set('db', $db);
            \Zend_Db_Table_Abstract::setDefaultAdapter($db);
        }
    }

    /**
     * Configuring session namespace.
     */
    public static function initSessionNamespace()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {

            $namespace = strtoupper(self::$module);
            new \Zend_Session_Namespace($namespace);

            $auth = \Zend_Auth::getInstance()->setStorage(
                new \Zend_Auth_Storage_Session($namespace)
            );
        }
    }

    /**
     * Configuring charser in HTTP headers.
     */
    public static function initHeaders()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            header(sprintf('Content-Type: text/html; charset=%s', self::$charset));
        }
    }

    /**
     * Configuring view helpers.
     */
    public static function initViewHelpers()
    {
        $view = new \Zend_View();
        $view->setEncoding(strtolower(self::$charset));
        foreach (self::$viewHelpers as $suffix => $path) {
            $view->addHelperPath($path, $suffix);
        }
        $viewRenderer = new \Zend_Controller_Action_Helper_ViewRenderer($view);
        \Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        \Zend_Registry::set('view', $view);
    }

    /**
     * Configuring view layout.
     */
    public static function initViewLayout()
    {
        if (!isset($_GET['ajax'])) {
            $path = sprintf('%s/%s/views/layouts', self::$applicationPath, self::$module);
            if (file_exists($path . '/main.phtml')) {
                \Zend_Layout::startMvc(
                    array(
                        'layoutPath' => $path,
                        'layout'     => 'main'
                    )
                );
            }
        }
    }

    /**
     * Initing the module bootstrap.
     */
    public static function initModuleBootstrap()
    {
        $file  = sprintf('%s/%s/Bootstrap.php', self::$applicationPath, self::$module);
        $class = sprintf('%s_Bootstrap', ucfirst(strtolower(self::$module)));

        if (file_exists($file) and is_readable($file)) {

            require_once $file;
            $reflection = new \ReflectionClass($class);
            $methods    = $reflection->getMethods(\ReflectionMethod::IS_STATIC);

            foreach ($methods as $method) {
                $method = (string)$method->name;
                if (strlen($method) > 4 and substr($method, 0, 4) === 'init') {
                    $reflection->getMethod($method)->invoke($reflection->newInstance());
                }
            }
        }
    }
}
