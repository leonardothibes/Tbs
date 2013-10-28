<?php
/**
 * @package Tbs\ZfComponents\V1\Bootstrap
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1\Bootstrap;

/**
 * Abstraction of Zend Framework 1.x bootstrap.
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
        $reflection = new ReflectionClass($this);
        $methods    = $reflection->getMethods(ReflectionMethod::IS_STATIC);

        foreach ($methods as $method) {
            $method = (string)$method->name;
            if (strlen($method) > 5 and substr($method, 0, 5) === 'init') {
                $reflection->getMethod($method)->invoke($this);
            }
        }
    }
}
