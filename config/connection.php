<?php 
	// Session start for work everywhere
session_start();

$servername = "rsudjarse.id";
$username = "rsudjars_tes";
$password = "vn,.hLKjqy.#";
$db       = "rsudjars_safety";

// Create connection
$link = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}


