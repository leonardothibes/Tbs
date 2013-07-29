<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage Loader
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace Tbs;

/**
 * Class autoloader.
 *
 * @category Library
 * @package Tbs
 * @subpackage Loader
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class Loader
{
	/**
	 * Register the autoloader.
	 * @return void
	 */
	public static function Register()
	{
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	/**
	 * Autoload a class.
	 *
	 * @param string $class Class name.
	 * @return bool
	 */
	public static function autoload($class)
	{
		$className = ltrim($className, '\\');
		$fileName  = '';
		$namespace = '';

		if ($lastNsPos = strrpos($className, '\\')) {
			$namespace = substr($className, 0, $lastNsPos);
			$className = substr($className, $lastNsPos + 1);
			$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}

		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		require_once $fileName;
	}
}
