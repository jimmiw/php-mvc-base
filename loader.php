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

require(ABSPATH.'functions.php');
require(ABSPATH.'config/environment.inc.php');
require(ABSPATH.'config/db.inc.php');

/** 
 * includes different class objects without me lifting a finger
 * @param $name       the name of the objec t to load
 */
function __autoload($class_name) {
  require_once 'models/'.$class_name.'.class.php';
}

?>