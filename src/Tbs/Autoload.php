<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Autoload
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;

/**
 * Class autoloader.
 *
 * @category Library
 * @package Tbs
 * @subpackage Autoload
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 * @link <http://www.php-fig.org/psr/0/>
 */
class Autoload
{
    /**
     * Register the autoloader.
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'loadClass'));
    }

    /**
     * Autoload a class.
     *
     * @param  string $class Class name.
     * @link   <http://www.php-fig.org/psr/0/>
     * @throws \Tbs\Autoload\Exception
     */
    public static function loadClass($className)
    {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        if (!file_exists($fileName)) {
            require_once 'Tbs/Autoload/Exception.php';
            throw new \Tbs\Autoload\Exception(
                sprintf('Could not load file: "%s"', $fileName)
            );
        }

        require_once $fileName;
    }
}
