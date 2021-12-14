<?php 
  include_once('../connection.php');
  include_once('../config.php');

  $mode 		 		= mysqli_real_escape_string($link, $_GET['mode']);
  $id_question  = $_GET['id'];
  $answer 	 		= $_GET['answer'];
  
  if (isset($_SESSION['administrator'])) {
  	$user = '111105';
  } else {
  	$user = $_SESSION['guest'];
  }

	$query 			= "INSERT INTO m_answers VALUES(NULL, '".$mode."', '".$id_question."', '".$answer."','".$user."')";
	mysqli_query($link, $query);
  echo "success";