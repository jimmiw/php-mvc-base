<?php

/**
 * Helps with loading the environment.
 *
 * The ABSPATH is defined using the current file.
 *
 * The APPROOT is used for saying where out APP is laying. I had a problem with
 * putting projects in sub directories, which made the router fail. Defining and
 * using this path, helps determine the correct routes.
 */
// defindes the absolute path to the files
define('ABSPATH', dirname(__FILE__).'/');
// defines the application root
define('APPROOT', substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '/app/router.php')));

require(ABSPATH.'config/environment.inc.php');
require(ABSPATH.'config/db.inc.php');

/** 
 * includes different class objects without lifting a finger
 * @param string $className the name of the object to load
 */
function __autoload($className) {
  require_once 'models/'.$className.'.class.php';
}

?>
