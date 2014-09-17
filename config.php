<?php
$host = "localhost";
$user = 'root';
$password = 'orange';
$database = 'wx';
$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_errno) {
  printf("Connect failed: %s\n", $mysqli->connect_error);
  exit();
}
//$mysqli->close();
?>