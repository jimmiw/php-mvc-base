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
 * returning this data prefixed with the table name.field name.
 *
 * If you have a table created like this:
 * create table users(
 *   id int primary key auto_increment,
 *   name varchar(255)
 * );
 *
 * Then the data returned from a "select * from users" will look like this:
 * array(array('users.id' => 1, 'users.name' => 'jimmiw' ),...)
 *
 * @param $result, the result set from your mysql_query.
 * @return the data from the result, nicely prefixed with the table name
 */
function mysql_fetch_prefixed_data($result) {
  // placeholder for the data
  $data = array();
  // placeholder for the meta data
  $metaData = null;
  
  // runs through the rows in the result set
  while($row = mysql_fetch_row($result)) {
    // if the metadata is not initialized, initialize it.
    if(!isset($metaData)) {
      $metaData = array();
      // runs through each tuple, getting the table name and field name
      for($i = 0; $i < sizeOf($row); $i++) {
        $meta = mysql_fetch_field($result, $i);
        $metaData[$i] = $meta->table.".".$meta->name;
      }
    }
    
    // constructs a placeholder to hold the data from the table
    $dataRow = array();
    // runs through the data, adding the "row name" and the actual data from the row
    for($i =  0; $i < sizeOf($row); $i++) {
      $dataRow[$metaData[$i]] = $row[$i];
    }
    // adds the row data to the data array
    $data[] = $dataRow;
  }
  
  return $data;
}

?>
