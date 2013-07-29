<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Bootstrap
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: bootstrap.php 21/06/2013 15:20:39 leonardo $
 */

//Definindo caminho para a aplicação.
define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../../src/Phpskel/application'));

//Definindo ambiente onde está rodando.
define('APPLICATION_ENV', 'testing');

//Definindo o "include_path".
set_include_path(implode(PATH_SEPARATOR, array(
	realpath(APPLICATION_PATH . '/../library'),
	realpath(APPLICATION_PATH . '/models'),
	get_include_path(),
)));

//Incluindo o PHPUnit.
require_once 'PHPUnit/Autoload.php';

/** @see Zend_Application **/
/* require_once 'Zend/Application.php';

//Rodando o Booststrap da aplicação.
$application = new Zend_Application(
	APPLICATION_ENV,
	APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap(); */

//Registrando configuração dos testes.
/* $config = new Zend_Config_Ini('config.ini', APPLICATION_ENV);
Zend_Registry::set('tests', $config); */