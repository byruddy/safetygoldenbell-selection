<?php 
  include_once('../connection.php');
  include_once('../config.php');

	$_SESSION['is_logged_in'] = true;
	$_SESSION['guest'] 				= uniqid();
	header('Location: '.BASE_URL); exit;
  