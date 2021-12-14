<?php 
	// Session start for work everywhere
session_start();

	// Set host and database
$host = "localhost";
$user = "root";
$pass = "";

	// Database name
$db   = "kp_quiz";

	// Create a connection
$link = mysqli_connect($host,$user,$pass, $db);

	// Checking for connection function
if (!$link) {
	echo "<b>Connection failed!</b>";
}



