<?php

function get_stylesheet($stylesheet) {
  return app_path('stylesheet').$stylesheet;
}

function get_javascript($javascript) {
  return app_path('javascript').$javascript;
}

function app_path($type = '') {
  $path = APPROOT.'/';
  
  if($type == 'stylesheet') {
    $path .= 'public/stylesheets/';
  }
  else if($type == 'javascript') {
    $path .= 'public/javascripts/';
  }
  
  return $path;
}

?>