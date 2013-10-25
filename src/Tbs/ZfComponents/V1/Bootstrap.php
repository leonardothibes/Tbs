<?php
/**
 * @package Tbs\ZfComponents\V1
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs\ZfComponents\V1;

/**
 * Bootstrap class for ZF1 modules.
 *
 * @package Tbs\ZfComponents\V1
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Bootstrap extends \Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Application path of ZF1 modules.
     * @var string
     */
    public static $applicationPath = null;

    /**
     * Charset.
     * @var string
     */
    static public $charset = 'UTF-8';

    /**
     * Current module name.
     * @var string
     */
    static public $module = 'default';

    /**
     * Initing application path of ZF1 modules.
     */
    public static function initApplicationPath()
    {
        if (!defined('APPLICATION_PATH')) {
            throw new \Tbs\ZfComponents\V1\Bootstrap\Exception(
                'The constant "APPLICATION_PATH" is not defined'
            );
        }
        self::$applicationPath = APPLICATION_PATH;
    }
}
