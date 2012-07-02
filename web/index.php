<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
date_default_timezone_set('CET');

// defines the web root
define('WEB_ROOT', substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], '/index.php')));
// defindes the path to the files
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
// defines the cms path
define('CMS_PATH', ROOT_PATH . '/lib/base/');

// starts the session
session_start();

/**
 * Standard autoloader
 * @param string $className
 */
function __autoload($className) {
	// controller autoloading
	if (strlen($className) > 10 && substr($className, -10) == 'Controller') {
		if (file_exists(ROOT_PATH . '/app/controllers/' . $className . '.php') == 1) {
			require_once ROOT_PATH . '/app/controllers/' . $className . '.php';
		}
	}
	else {
		if (file_exists(CMS_PATH . $className . '.php')) {
			require_once CMS_PATH . $className . '.php';
		}
		else {
			require_once ROOT_PATH . '/app/models/'.$className.'.php';
		}
	}
}

// loads the environment settings
require(ROOT_PATH . '/config/environment.inc.php');
// loads the database config
require(ROOT_PATH . '/config/db.inc.php');

// includes the system routes
include(ROOT_PATH . '/config/routes.php');

// tries to find the route and run the given action on the controller
try {
	// fetches the current URI
	$uri = $_SERVER['REQUEST_URI'];
	$uri = substr($uri, strlen(WEB_ROOT));
	// if the route isn't defined, try to add a trailing slash
	if (!isset($routes[$uri])) {
		$uri .= '/';
	}
	// fetches the current route
	$routeFound = isset($routes[$uri])  ? $routes[$uri] : false;

	// if a matching route was found
	if ($routeFound) {
		list($name, $action) = explode('#', $routeFound);
		// initializes the controller
		$controller = ucfirst($name) . 'Controller';
		// constructs the controller
		$controller = new $controller();
		// executes the action on the controller
		$controller->execute($action);
	}
	// no route found, throw an exception to run the error controller
	else {
		throw new Exception('no route added for ' . $_SERVER['REQUEST_URI']);
	}
}
catch(Exception $exception) {
	// runs the error controller
	$controller = new ErrorController();
	$controller->setException($exception);
	$controller->execute('error');
}
