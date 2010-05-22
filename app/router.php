<?php

// starting the output buffering.
// this is turned on, so I can set different headers after calling
// session_start at the top here.
ob_start();

// starts the session
session_start();

// starts loading the environment
include('../loader.php');

// loads my configurations into the system
require_once('../config/environment.inc.php');
// connects to the database
include('../lib/db.inc.php');

/** 
 * includes different class objects without me lifting a finger
 * @param $name       the name of the objec t to load
 */
function __autoload($class_name) {
  require_once '../lib/'.$class_name.'.inc.php';
}

// removes the GET parameters from the URL
$url = explode("?",$_SERVER['REQUEST_URI']);
// since we only need the "path", we take the data at the first index
$url = $url[0];
// splits the parameters at the / sign and removes any empty spaces in the path.
$urlArray = explode("/", $url);
// constructs an array to hold the path
$path = array();
// runs through the url pieces, removes the spaces
for($i = 0; $i < sizeOf($urlArray); $i++) {
  $urlPiece = $urlArray[$i];
  if($urlPiece != "") {
    $path[] = $urlPiece;
  }
}

/**
 * tries to find an action to call using the path called (url).
 * @param $path, the url/path to find a controller from.
 * @param $params, an array passed as reference, so additional parameters can be used later
 */
function findController($path, $params) {
  $action = '';
  $routeFound = false;
  
  // runs through the controllers, finding a match
  for($i = sizeOf($path); $routeFound == false && $i >= 0; $i--) {
    // initializes the action
    $action = "controllers";
    // initializes the parameters array
    $params = array();

    // creates the file
    foreach(range(0, $i) as $index) {
      if($path[$index] != "") {
        $action .= "/";
        $action .= $path[$index];
      }
    }
    // creates the array of parameters
    foreach(range($i+1, sizeOf($path)) as $index) {
      if($path[$index] != "") {
        $params[] = $path[$index];
      }
    }

    if(is_file($action.".php")) {
      $routeFound = true;
      $action .= ".php";
    }
    else if(is_file($action."/index.php")) {
      $routeFound = true;
      $action .= "/index.php";
    }
  }
  
  // if we couldn't find a valid route, remove the "current action"
  if(!$routeFound) {
    // resets the action and the params array
    $action = "";
    $params = array();
  }
  
  return $action;
}

$params = array();
// tries to find a controller
$action = findController($path, &$params);

// if a route was found, include it!
if($action != "") {
  include($action);
}
// uncomment this to have "empty" urls point to a certain location
/*else if($_SERVER['REQUEST_URI'] == "" || $_SERVER['REQUEST_URI'] == "/") {
  header("Location: /blog");
}*/
else {
  // sets the 404 header
  header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
  header("Status: 404 Not Found");
  include("views/errors/404.php");
}

// flushes the buffer data
ob_end_flush();

?>
