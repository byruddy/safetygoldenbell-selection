<?php 
include_once('../connection.php');
include_once('../config.php');

if(isset($_GET['id'])){

  $id =   mysqli_real_escape_string($link, $_GET['id']);
  
  $query = sprintf("SELECT * FROM participants WHERE nim = '%s'",
    mysqli_real_escape_string($link, $id));
  $result = mysqli_query($link, $query);

  if (mysqli_num_rows($result) == 1) {
  	$_SESSION['is_logged_in'] = true;
    $_SESSION['nim'] = $id;
  	$_SESSION['administrator'] = true;
  	$_SESSION['guest_name'] 	 = NULL;
  	echo '{"results": "success"}';
  } else {
  	echo '{"results": "failed"}';
  }
} else {
	header('Location: '.BASE_URL); exit;
}


