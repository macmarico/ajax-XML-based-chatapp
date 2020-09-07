<?php
session_start();

$dbhost = "fdb12.awardspace.net"; // this will ususally be 'localhost', but can sometimes differ
$dbname = "1983539_manish"; // the name of the database that you are going to use for this project
$dbuser = "1983539_manish"; // the username that you created, or were given, to access your database
$dbpass = "bi0hazard"; // the password that you created, or were given, to access your database

$conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());
mysqli_select_db($conn,$dbname) or die("MySQL Error: " . mysql_error());
?>