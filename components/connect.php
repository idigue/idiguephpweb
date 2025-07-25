<?php
const dbhost = "localhost";
const dbname = "idigueco_idigue";
const dbusername = "idigueco";
const dbpassword = "op00Zd24Yv";
function connect($host, $name, $username, $password)
{
  $db = new mysqli($host, $username, $password, $name);
  date_default_timezone_set('America/Vancouver');
  if ($db->connect_error) {
    die('error' . $db->connect_error);
  }
  return $db;
}
?>