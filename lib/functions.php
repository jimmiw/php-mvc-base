<?php

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
