<?php

$host = "188.40.115.114"; /* Host name */
$user = "phil5521_data"; /* User */
$password = "!EH!Pn@iR97&Qh38"; /* Password */
$dbname = "phil5521_database"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}