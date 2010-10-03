<?php

// creates the connection to the database server
$connection_link = mysql_connect($conf['db_host'], $conf['db_user'], $conf['db_password']);

// tests if there is a connection
if(!$connection_link) {
  die('Could not connect: ' . mysql_error());
}
else {
  // connects to the correct database
  mysql_select_db($conf['db_name'], $connection_link);
}

/*
// initializes the database connection
$dbh = false;

try {
  $dbh = new PDO('mysql:host='.$conf['db_host'].';dbname='.$conf['db_name'], $conf['db_user'], $conf['db_password']);
}
catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}*/

?>
