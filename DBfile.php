<?php
/*  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  */

define ('DB_USER', 'kumar');
define ('DB_PASSWORD', 'kumar');
define ('DB_HOST', 'handson-mysql');
define ('DB_NAME', 'LabBoard');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)

OR die ('Could not connect to MySQL: '.mysql_error());
if ($conn->connect_error)
{
	die("Connection failed: " . $conn->connect_error);
}
?>