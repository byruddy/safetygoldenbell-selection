<?php 
  include_once('../connection.php');
  include_once('../config.php');


	$sql = "SELECT * FROM m_questions";
	$runSql = mysqli_query($link, $sql);
	$reset_formula = '';
	while($row = mysqli_fetch_assoc($runSql)){
		$reset_formula .= $row['id'].',';
	}
	$reset_formula = substr($reset_formula, 0,-1);
	// echo $reset_formula;
	mysqli_query($link, "UPDATE app_config SET formula ='".$reset_formula."'");
	 

