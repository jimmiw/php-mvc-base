<?php

// starting the output buffering.
// this is turned on, so I can set different headers after calling
// session_start at the top here.
ob_start();

// starts the session
session_start();

/**
 * Finds the controller to call
 */
function findController($path, $params) {
  $requestURI = removeParameters($path);
  
  if(is_file("controllers".$requestURI.".php")) {
    return "controllers".$requestURI.".php";
  }
  else if(is_file("controllers".$requestURI."/index.php")) {
    return "controllers".$requestURI."/index.php";
  }
  else {
    // finds the last position of a front slash
    $slashPosition = strrpos($requestURI,'/');
    // finds the "directory" to remove
    $removeableParam = substr($requestURI,$slashPosition+1);
  
    // if there is some data in the string, save it to the parameter array
    if($removeableParam != "") {
      $params[] = $removeableParam;
    }
  
    // removes the previous "directory"
    $requestURI = substr($requestURI,0, $slashPosition);
    // if there still is data left, do a recursive call to this function
    if($requestURI != "") {
      return findController($requestURI, &$params);
    }
  }
  
  // returns an empty string, if a controller was not found
  return "";
}

/**
 * Removes all parameters from the given path (all chars including and after
 * the ? char ).
 * @param string $path the path to remove the parameters from
 * @return string the path without the parameters
 */
function removeParameters($path) {
  $path = explode("?", $path);
  $path = $path[0];
  if(strrpos($path,'/') == strlen($path)-1) {
    $path = substr($path,0,strlen($path)-1);
  }
  return $path; 
}

/**
 * Removes session variables that the router needs to use
 */
function cleanUpSession() {
  unset($_SESSION['hooksEnd']);
  unset($_SESSION['conf']);
}

/**
 * Runs through the _end_ hooks and executes them!
 *
 * A hook is just a function name etc, that will be eval'd.
 *
 * Use this to run functions that does clean ups or to execute different scripts
 * at the end of the router life cycle
 */
function hooksEnd() {
  foreach($_SESSION['hooksEnd'] as $hook) {
    eval($hook);
  }
}

/**
 * Loads the libraries in the lib folder.
 */
function loadVendorLibraries() {
  $hooks = array();
  
  $vendorFolder = "../vendor/";
  
  // opens the lib folder
  if($dir = opendir($vendorFolder)) {
    // runs through the files, loading them one by one
    while(false !== ($file = readdir($dir))) {
      if($file != "." && $file != "..") {
        if(is_file($vendorFolder.$file) && preg_match('/.php$/', $file)) {
          include_once($vendorFolder.$file);
        }
      }
    }
    
    // closes the folder handler
    closedir($dir);
  }
  
  // saves the hooks found
  $_SESSION['hooksEnd'] = $hooks;
}

/**
 * Finds the current URL. It simply takes the request URI and removes the 
 * APPROOT from it.
 * For more information about the APPROOT, see /loader.php
 */
function currentUrl() {
  return substr($_SERVER['REQUEST_URI'], strlen(APPROOT));
}

// includes the loader file, which loads in the environment
include('../loader.php');

$params = array();
// tries to find a controller to use
$controller = findController(currentUrl(), &$params);

// loads the libraries in the vendor folder
loadVendorLibraries();

// if a controller was found, use it
if($controller != "") {
  include($controller);
}
// show an error page if no controller was found
else {
  // sets the 404 header
  header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
  header("Status: 404 Not Found");
  
  include("views/errors/404.php");
}

// executes the "end hooks"
hooksEnd();
// runs a cleanup in the session
cleanUpSession();

// flushes the buffer data
ob_end_flush();

?>
