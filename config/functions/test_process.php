<?php 
  include_once('../connection.php');
  include_once('../config.php');

  // Auth
  if(!isset($_SESSION['is_logged_in'])){
    header('Location: '.BASE_URL); exit;
  }

  $formula		  = mysqli_real_escape_string($link, $_POST['formula']);

	if($formula == ''){
		echo "finish"; exit;
	} else {
		if(strlen($formula) > 1){
		  $diceTemp 		= explode(',', $formula);
		  $keyrand 			= array_rand($diceTemp, 1);
			$diceSelect 	= $diceTemp[$keyrand];

			if(!isset($_SESSION['administrator']) && $diceSelect >50){
				echo "finish"; exit;
			}

			$query 				= "SELECT * FROM m_questions WHERE id = ".$diceSelect;
		} else {
			$query 				= "SELECT * FROM m_questions WHERE id = ".$formula;
		}
		$runSQL = mysqli_query($link, $query);

		while($row = mysqli_fetch_assoc($runSQL)){
			if(strlen($formula) > 1){
			  unset($diceTemp[$keyrand]);
				$diceTemp 		= implode($diceTemp, ',');
			} else {
				$diceTemp = $newSelect = NULL;
			}
			if($row['sheet'] == 'primary'){
				$sheet = 'Primary Safety Quiz';
			} elseif($row['sheet'] == 'secondary'){
				$sheet = 'Secondary Safety Quiz';
			} elseif($row['sheet'] == 'occupational'){
				$sheet = 'Occupational Health Quiz';
			} elseif($row['sheet'] == 'disaster'){
				$sheet = 'Disaster Prevention';
			} elseif($row['sheet'] == 'posting'){
				$sheet = 'Posting Article Quiz';
			}
		  // $newSelect 		= array_rand($diceTemp, 1);
			$dataQuestion = array('id'=>$row['id'],'question'=>$row['question'],'answer'=>$row['answer'],'sheet'=>$sheet,'formula'=>$diceTemp);
		}
	  echo json_encode($dataQuestion);
	}