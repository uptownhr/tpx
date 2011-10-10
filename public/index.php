<?php

// increase it as needed
ini_set("memory_limit", "512M");

// define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__)) . '/../application');

// define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// define library path
set_include_path(implode(PATH_SEPARATOR, array(
	APPLICATION_PATH . '/../library',
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$autoloader = Zend_Loader_Autoloader::getInstance(); 
$autoloader->setFallbackAutoloader(true); 
$application->bootstrap();
$db = Zend_Db_Table::getDefaultAdapter();
Zend_Registry::set('db',$db);
Zend_Registry::set('application_env', APPLICATION_ENV);

$application->run();