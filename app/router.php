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
  
  $dataFound = findPath($requestURI);
  
  if(getConfiguration('route.storage')) {
    if($dataFound != null) {
      $params = $dataFound['params'];
      return $dataFound['path'];
    }
  }
  
  if(is_file("controllers".$requestURI.".php")) {
    if(getConfiguration('route.storage')) {
      storePath("controllers".$requestURI.".php", $params);
    }
    return "controllers".$requestURI.".php";
  }
  else if(is_file("controllers".$requestURI."/index.php")) {
    if(getConfiguration('route.storage')) {
      storePath("controllers".$requestURI."/index.php", $params);
    }
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
 * Stores the given path (in the session), using the current REQUEST_URI as key
 * @param string $path the path to save (a controller found)
 * @param array $params the parameters found
 */
function storePath($path, $params) {
  $key = '_routes_';
  
  $requestURI = removeParameters($_SERVER['REQUEST_URI']);
  
  if(!isset($_SESSION[$key])) {
    $_SESSION[$key] = array();
  }
  
  // saves the current request, as the given path
  $_SESSION[$key][$requestURI] = array(
    'path' => $path,
    'params' => $params
  );
}

/** 
 * Tests if the given path was already found
 * @param string $path the path to test.
 * @return array the data found on the given PATH, else null
 */
function findPath($path) {
  // tests if the path is availiable
  if(isset($_SESSION['_routes_']) && isset($_SESSION['_routes_'][$path])) {
    return $_SESSION['_routes_'][$path];
  }
  // no path was found, return null!
  else {
    return null;
  }
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
function loadLibraries() {
  $hooks = array();
  
  // opens the lib folder
  if($librariesFolder = opendir('../lib')) {
    // runs through the files, loading them one by one
    while(false !== ($file = readdir($librariesFolder))) {
      if($file != "." && $file != "..") {
        if(is_file('../lib/'.$file)) {
          include_once("../lib/".$file);
        }
      }
    }
    
    // closes the folder handler
    closedir($librariesFolder);
  }
  
  // saves the hooks found
  $_SESSION['hooksEnd'] = $hooks;
}

// includes the loader file, which loads in the environment
include('../loader.php');
// includes the libraries to use
loadLibraries();


$params = array();
// tries to find a controller to use
$controller = findController($_SERVER['REQUEST_URI'], &$params);

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