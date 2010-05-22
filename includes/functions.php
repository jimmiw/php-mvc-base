<?php

/**
 * Helper function for finding the correct path of the given stylesheet
 * in the system
 * When linking to stylesheets, always remember to put them in the 
 * /public/stylesheets folder. You can have subfolders in the folder etc.
 *
 * Usage:
 * <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet('my_css.css'); ?>" />
 * This goes into your head section of your layout document.
 *
 * @param $stylesheet, the stylesheet you are trying to link to.
 * @return the path of the given stylesheet.
 */
function get_stylesheet($stylesheet) {
  return app_path('stylesheet').$stylesheet;
}


/**
 * Helper function for finding the correct path of the given javascript
 * in the system.
 * When linking to javascripts, always remember to put them in the 
 * /public/javascripts folder. You can have subfolders in the folder etc.
 *
 * Usage:
 * <script type="text/javascript" src="<?php echo get_javascript('my_js.js');?>"></script>
 * This goes into your head section of your layout document.
 *
 * @param $stylesheet, the stylesheet you are trying to link to.
 * @return the path of the given stylesheet.
 */
function get_javascript($javascript) {
  return app_path('javascript').$javascript;
}

/**
 * Helper function for finding the path in the system.
 * Use this with all your links, to make sure that your webapp can be placed
 * safely in sub folders on a server.
 * You can also use this function as a more general linking function. The
 * get_stylesheet and get_javascript functions both use this function
 * internally, to find the corrects paths around the system.
 * @param $type, optional parameter, used for finding stylesheets or js paths.
 * @return the path of the web app.
 */
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