<?php
/**
 * @category Tests
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

//Definindo caminho para a aplicação.
define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/../src/Tbs'));

//Definindo o "include_path".
set_include_path(implode(PATH_SEPARATOR, array(
	LIBRARY_PATH,
	get_include_path(),
)));

//Incluindo o PHPUnit.
require_once 'PHPUnit/Autoload.php';
