<?php

// creates the connection to the database server
$connection_link = mysql_connect(
  getConfiguration('db_host'),
  getConfiguration('db_user'),
  getConfiguration('db_password')
);

// tests if there is a connection
if(!$connection_link) {
  die('Could not connect: ' . mysql_error());
}
else {
  // connects to the correct database
  mysql_select_db(
    getConfiguration('db_name'),
    $connection_link
  );
}

?>
