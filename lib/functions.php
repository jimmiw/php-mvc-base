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
function stylesheet_tag($stylesheet) {
  $tag = sprintf(
    '<link rel="stylesheet" type="text/css" href="%s%s" />',
    app_path('stylesheet'),
    $stylesheet
  );
  
  return $tag;
}


/**
 * Helper function for finding the correct path of the given javascript
 * in the system.
 * When linking to javascripts, always remember to put them in the 
 * /public/javascripts folder. You can have subfolders in the folder etc.
 *
 * Usage:
 * <?php echo javascript_include_tag('my_js.js');?>
 * This goes into your head section of your layout document.
 *
 * @param $javascript, the javascript you are trying to link to.
 * @return the path of the given stylesheet.
 */
function javascript_include_tag($javascript) {
  $tag = sprintf(
    '<script type="text/javascript" src="%s%s"></script>',
    app_path('javascript'),
    $javascript
  );
  
  return $tag;
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
function image_tag($image, $options = null) {
  $htmlImage = '<img src="';
  $htmlImage .= app_path('image').$image;
  $htmlImage .= '"';
  $htmlImage .= ' alt="';
  $htmlImage .= (isset($options) && isset($options['alt'])? $options['alt'] : $image);
  $htmlImage .= '"';
  
  if(isset($options) && isset($options['class']) && $options['class'] != "") {
    $htmlImage .= ' class="'.$options['class'].'"';
  }
  if(isset($options) && isset($options['id']) && $options['id'] != "") {
    $htmlImage .= ' id="'.$options['id'].'"';
  }
  if(isset($options) && isset($options['style']) && $options['style'] != "") {
    $htmlImage .= ' style="'.$options['style'].'"';
  }
  
  $htmlImage .= '" />';
  return $htmlImage;
}

/**
 * Adds the applications path to the given URL.
 * @param string $url the URL to add the application's path to.
 * @return string the (perhaps) modified URL, with the application's path (if needed)
 */
function _addPath($url) {
  // if it is not an external link
  if(!preg_match('/^http(s)*:\/\//', $url)) {
    // if it starts with a frontslash, remove it
    if(preg_match('/^\//', $url)) {
      $url = substr($url,1);
    }
    
    // adds the app_path to the url
    $url = sprintf(
      "%s%s",
      app_path(),
      $url
    );
  }
  
  // returns the url (which might be modified)
  return $url;
}

/**
 * Constructs an a-tag, using the given data.
 * @param string $contents the contents to have inside the link
 * @param string $url the url to link to
 * @param array $htmlOptions the options to add to the link (e.g. the class, style etc)
 * @return string the a-tag constructed, using the given details.
 */
function link_to($contents, $url, $htmlOptions = array()) {
  $options = "";
  // runs through the HTML options and adds the keys and values
  // one by one.
  foreach($htmlOptions as $key => $value) {
    $options .= sprintf(
      ' %s="%s"',
      $key,
      $value
    );
  }
  
  // completes the a-tag
  $tag = sprintf(
    '<a href="%s"%s>%s</a>',
    _addPath($url),
    $options,
    $contents
  );
  
  return $tag;
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
