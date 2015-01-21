<?php

if(!is_null(getenv('APPLICATION_ENV'))) {
    putenv('APPLICATION_ENV=development');
}

/**
 * Display all errors when APPLICATION_ENV is development.
 */
if (getenv('APPLICATION_ENV') == 'development') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

if(!is_null(getenv('ZF2_PATH'))) {
    putenv('ZF2_PATH=' . realpath(__DIR__ . '/vendor/zendframework/zendframework/library/'));
}

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
$appcfg = require __DIR__.'/config/application.config.php';
$zapp = Zend\Mvc\Application::init($appcfg);
$zapp->run();
