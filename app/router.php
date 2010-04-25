<?php

// starting the output buffering.
// this is turned on, so I can set different headers after calling
// session_start at the top here.
ob_start();

// starts the session
session_start();

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
$path = explode("?",$_SERVER['REQUEST_URI']);
// since we only need the "path", we take the data at the first index
$path = $path[0];
// removes the first / (if any)
$path = substr($path, 1);
// splits the parameters at the / sign
$path = explode("/", $path);

$routeFound = false;
$action = "";
$params = array();

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

// if a route was found, include it!
if($routeFound) {
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
