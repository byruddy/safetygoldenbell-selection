<?php 
  include_once('../connection.php');
  include_once('../config.php');

  $setName = mysqli_real_escape_string($link, $_POST['name']);
  $_SESSION['guest_name'] = $setName;
	$query 			= "INSERT INTO m_guests VALUES(NULL, '".$setName."', '".date('Y/m/d H:i:s')."')";
	mysqli_query($link, $query);
  echo "success";