<?php
/**
 * @package Tbs\ZfComponents\V1\Bootstrap
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1\Bootstrap;

require_once 'Zend/Application/Bootstrap/ResourceBootstrapper.php';
require_once 'Zend/Application/Bootstrap/Bootstrapper.php';
require_once 'Zend/Application/Bootstrap/BootstrapAbstract.php';
require_once 'Zend/Application/Bootstrap/Bootstrap.php';
require_once 'Zend/Application/Module/Autoloader.php';
require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Controller/Request/Http.php';
require_once 'Zend/Controller/Router/Route/Regex.php';
require_once 'Zend/Registry.php';

/**
 * Abstraction of Zend Framework 1.12.x bootstrap.
 *
 * @package Tbs\ZfComponents\V1\Bootstrap
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
abstract class Abstraction extends \Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Constructor
     *
     * Ensure FrontController resource is registered
     *
     * @param  Zend_Application|Zend_Application_Bootstrap_Bootstrapper $application
     * @return void
     */
    public function __construct($application)
    {
        parent::__construct($application);
        $this->runAllInits();
    }

    /**
     * Run all the methos whit "init*" in begin of the name.
     */
    protected function runAllInits()
    {
        $reflection = new \ReflectionClass(get_class($this));
        $methods    = $reflection->getMethods(\ReflectionMethod::IS_STATIC);

        foreach ($methods as $method) {
            $method = (string)$method->name;
            if (strlen($method) > 4 and substr($method, 0, 4) === 'init') {
                $reflection->getMethod($method)->invoke($this);
            }
        }
    }
}
