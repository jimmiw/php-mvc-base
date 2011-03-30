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
  else if($type == 'image') {
    $path .= 'public/images/';
  }
  
  return $path;
}

/**
 * Creates a html image element, using the given image src and the options array.
 * @param $image, the image src.
 * @param $options, an array with additional options to set.
 * @return returns the html image element, with a src set to the given image.
 */
function image_link($image, $options = null) {
  $htmlImage = '<img src="';
  $htmlImage .= app_path('image').$image;
  $htmlImage .= '"';
  $htmlImage .= ' alt="';
  $htmlImage .= (isset($options) && isset($options['alt'])? $options['alt'] : $image);
  $htmlImage .= '"';
  if($options['class'] != "") {
    $htmlImage .= ' class="'.$options['class'].'"';
  }
  if($options['id'] != "") {
    $htmlImage .= ' id="'.$options['id'].'"';
  }
  if($options['style'] != "") {
    $htmlImage .= ' style="'.$options['style'].'"';
  }
  $htmlImage .= '" />';
  return $htmlImage;
}

/**
 * A simple function for fetching the data in the given mysql result set, and
 * returning this data in prefixed arrays with the [table name][field name]
 *
 * @param $statement, the statement set from your query.
 * @return the data from the result, nicely prefixed with the table name
 */
function fetchPrefixedData($statement) {
  // sets the fetch mode
  $statement->setFetchMode(PDO::FETCH_NUM);
   
  // placeholder for the data
  $data = array();
  // placeholder for the meta data
  $metaData = null;

  // runs through the rows in the result set
  while($row = $statement->fetch()) {
    $dataRow = array();
     
    for($i = 0; $i < sizeOf($row); $i++) {
      $meta = $statement->getColumnMeta($i);
       
      // finds the table name
      $table = $meta['table'];
      // no table name? properly a concat etc then, add a . as table name
      if($table == "") {
        $table = '.';
      }
       
      // adds the current table name to the data array
      if(!isset($dataRow[$table])) {
        $dataRow[$table] = array();
      }
       
      // saves the data, prefixed by the table name
      $dataRow[$table][$meta['name']] = $row[$i];
    }
     
    // adds the data row to the array of data
    $data[] = $dataRow;
  }
   
  // returns the data found
  return $data;
}

?>
