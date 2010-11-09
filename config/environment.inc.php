<?php

// production environment specific configurations
if($_SERVER["SERVER_NAME"] == 'westsworld.dk' || $_SERVER["SERVER_NAME"] == 'www.westsworld.dk') {
  // database configurations
  storeConfiguration('db_password', '');
  storeConfiguration('db_user', 'root');
  storeConfiguration('db_host', 'localhost');
  storeConfiguration('db_name', 'production_database');
  storeConfiguration('db_prefix', '');
  storeConfiguration('route.storage', true);
}
// all other environments:
// includes test and development and staging
else {
  // database configurations
  storeConfiguration('db_password', '12345');
  storeConfiguration('db_user', 'root');
  storeConfiguration('db_host', '127.0.0.1');
  storeConfiguration('db_name', 'test_database');
  storeConfiguration('db_prefix', '');
}
?>
