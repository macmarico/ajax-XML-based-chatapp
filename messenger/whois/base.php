<?php
session_start();

$dbhost = "fdb26.awardspace.net"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "3390921_mac"; // the name of the database that you are going to use for this project
$dbuser = "3390921_mac"; // the username that you created, or were given, to access your database
$dbpass = "bi0hazard"; // the password that you created, or were given, to access your database

$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysqli_select_db($conn,$dbname) or die("MySQL Error: " . mysql_error());
?>