<?php 
  include_once('../connection.php');
  include_once('../config.php');

  // Auth
  if(!isset($_SESSION['is_logged_in'])){
    header('Location: '.BASE_URL); exit;
  }
  $sortby			  		= mysqli_real_escape_string($link, $_GET['sortby']);
  $formula		  		= mysqli_real_escape_string($link, $_GET['formula']);
  $action		  			= mysqli_real_escape_string($link, $_GET['action']);
  $sheet_selected		= mysqli_real_escape_string($link, $_GET['sheet_selected']);


  if($formula == ''){
	  // ALGORITHM GET TOP QUESTIONS FAILS
		$questionList = '';
	  $sortMostFail = NULL;
	  $questionListID = explode('.', $sheet_selected);
	  for ($k=0; $k < count($questionListID); $k++) { 
	    $numRowsPASS = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `m_answers` WHERE id_question = ".$questionListID[$k]." AND answer = 1"));
	    $numRowsFAIL = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `m_answers` WHERE id_question = ".$questionListID[$k]." AND answer = 0"));

	    if (($numRowsPASS-$numRowsFAIL) < 0) {
	      $sortMostFail['question_sort'][$k] = ($numRowsPASS-$numRowsFAIL).'.'.$questionListID[$k];
	    }
	  }

	  if ($sortMostFail != NULL) {
	    sort($sortMostFail['question_sort']);
	    for ($l=0; $l < count($sortMostFail['question_sort']); $l++) { 
        $sortEx = explode('.', $sortMostFail['question_sort'][$l]);
        $runSql = mysqli_query($link, "SELECT * FROM m_questions WHERE id = ".$sortEx[1]);
        $dataDB = mysqli_fetch_assoc($runSql);
        $questionList .= '<li>'.$dataDB['question'].'<br><span class="font-weight-bold">'.$dataDB['answer'].'</span><div class="mt-1"><a href="'.BASE_URL.'dashboard/focus/?id='.$dataDB['id'].'" target="_blank" class="btn btn-sm btn-light" style="border-color: #D2D2D2; font-size: 12px;"><i class="fa fa-crosshairs"></i> Focus</a> <small class="text-muted">Fail Answer : <span class="text-danger font-weight-bold">'.str_replace('-', '', $sortEx[0]).'x</span></small></div></li><hr>';
      }
	  }  else {
      $questionList .= '<div class="alert alert-warning" role="alert">Your brain is good condition! Keep practice for Ranking #1</div>';
	  }

		$data = array('isFinish'=>true,'questionList' => $questionList);
	} else {
		if(strlen($formula) > 1){
		  $diceTemp 		= explode(',', $formula);
		  if($sortby == 'random'){
		  	$keyrand = array_rand($diceTemp, 1);
		  } elseif ($sortby == 'bysheet') {
		  	$keyrand = 0;
		  }
			$diceSelect 	= $diceTemp[$keyrand];

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
				$diceTemp = NULL;
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

      // Prepare data send
			$data = array('isFinish'=>false,'id'=>$row['id'],'question'=>$row['question'],'answer'=>$row['answer'],'sheet'=>$sheet,'formula'=>$diceTemp);
		}
  }
  echo json_encode($data);