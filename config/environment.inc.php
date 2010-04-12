<?php

$conf = array();

// production environment specific configurations
if($_SERVER["SERVER_NAME"] == 'westsworld.dk' || $_SERVER["SERVER_NAME"] == 'www.westsworld.dk') {
  // database configurations
  $conf['db_password'] = '';
  $conf['db_user'] = 'root';
  $conf['db_host'] = 'localhost';
  $conf['db_name'] = 'database';
  $conf['db_prefix'] = '';
}
// all other environments:
// includes test and development and staging
else {
  // database configurations
  $conf['db_password'] = '12345';
  $conf['db_user'] = 'root';
  $conf['db_host'] = 'localhost';
  $conf['db_name'] = 'database';
  $conf['db_prefix'] = '';
}
?>
