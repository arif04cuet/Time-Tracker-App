<?php

error_reporting(E_ERROR);
define('REQUEST_MICROTIME', microtime(true));

function pr($msg)
{
    echo "<pre>";
    print_r($msg);
    echo "</pre>";
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
