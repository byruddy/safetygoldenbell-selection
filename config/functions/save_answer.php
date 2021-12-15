<?php 
include_once('../connection.php');
include_once('../config.php');

  // Auth
if(!isset($_SESSION['is_logged_in'])){
	header('Location: '.BASE_URL); exit;
}
$response = [];

  // VALIDATION FOR RESULT
  // Get total questions
$query2        = "SELECT * FROM m_questions WHERE id IN (SELECT question_id FROM question_answers)";
$getData2      = mysqli_query($link, $query2);
$totalQuestion = mysqli_num_rows($getData2);

  // Get total score
$query3        = "SELECT * FROM participants WHERE nim = '".$_SESSION['nim']."'";
$getData3      = mysqli_query($link, $query3);
$totalScore    = mysqli_fetch_assoc($getData3)['score'];

  // if ($totalAnswers == $totalQuestion) {
  // 	echo json_encode(array('status' => 'finish')); exit;
  // }


  // Get question_answer
$user     = $_SESSION['nim'];
$formula  = explode(',',$_POST['formula']);
$question = $_POST['question_id'];
$answer   = $_POST['answer'];

  // Record answers
$dateNow = date('Y-m-d H:i:s');
mysqli_query($link, "INSERT INTO test_logs VALUES ('".$user."', '".$question."', '".$answer."', '".$dateNow."')");

// Get total score
	$query5        = "SELECT * FROM test_logs WHERE participant_id = '".$_SESSION['nim']."' ORDER BY date_choice ASC LIMIT 1";
	$getData5      = mysqli_query($link, $query5);
	$dateStart     = mysqli_fetch_assoc($getData5)['date_choice'];


	if (count($formula) == 1) {
  	// Get the answer of question
		$query4        = "SELECT answer FROM m_questions WHERE id = '".$question."'";
		$getData4      = mysqli_query($link, $query4);
		$realAnswer    = mysqli_fetch_assoc($getData4)['answer'];

  	// Check answers user
		if ($realAnswer == $answer) {
			$totalScore += 1;
			mysqli_query($link, "UPDATE participants SET score = ".$totalScore." WHERE nim = '".$_SESSION['nim']."'");
		}

		$response['r_timeStart'] = date('H:i:s', strtotime($dateStart));
		$response['r_timeFinish'] = date('H:i:s', strtotime($dateNow));
		$response['pass'] = $totalScore;
		$response['failed'] = $totalQuestion - $totalScore;
		$response['score'] = $totalScore * 10;
		$response['status'] = 'finish';


		// $q = "UPDATE m_tests SET end_date ='".date('H:i:s', strtotime($dateNow))."', pass='".$totalScore."', fail='".($totalQuestion - $totalScore)."', score='".($totalScore * 10.)"' WHERE session_id = '".$_SESSION['nim']."'";
		$q = "UPDATE m_tests SET end_date ='".date('H:i:s', strtotime($dateNow))."', pass ='".$totalScore."',  fail ='".($totalQuestion - $totalScore)."', score = '".($totalScore * 10)."' WHERE session_id = '".$_SESSION['nim']."'";
		// var_dump($q); exit;
		mysqli_query($link, $q);
		// echo $q; exit;

		// if (!$x) {
		// 	echo "Error: " . $q . "<br>" . mysqli_error($link); exit;
		// }

		echo json_encode($response); exit;
	} else {
  		// Get the answer of question
		$query4        = "SELECT answer FROM m_questions WHERE id = '".$question."'";
		$getData4      = mysqli_query($link, $query4);
		$realAnswer    = mysqli_fetch_assoc($getData4)['answer'];

  		// Check answers user
		if ($realAnswer == $answer) {
			$totalScore += 1;
			mysqli_query($link, "UPDATE participants SET score = ".$totalScore." WHERE nim = '".$_SESSION['nim']."'");
		}

  		// Create test result
		$query8        = "SELECT * FROM m_tests WHERE session_id = '".$_SESSION['nim']."' LIMIT 1";
		$getData8      = mysqli_query($link, $query8);
		$check = mysqli_num_rows($getData8);
		if ($check == 0) {
			// $q = "INSERT INTO m_tests VALUES (NULL, '".date('Y-m-d')."', '".."', '".date('H:i:s', strtotime($dateNow))."', '".$totalScore."', '".$totalQuestion - $totalScore."', '".$totalScore * 10."', '".$_SESSION['nim']."')";
			$q = "INSERT INTO m_tests VALUES (NULL, '".date('Y-m-d')."', '".date('H:i:s', strtotime($dateStart))."', '".date('H:i:s', strtotime($dateNow))."', '".$totalScore."', '".($totalQuestion - $totalScore)."', '".($totalScore * 10)."', '".$_SESSION['nim']."')";
				// var_dump($q); exit;
				mysqli_query($link, $q);
			} else {
				// update
				// $q = "UPDATE m_tests SET end_date ='".date('H:i:s', strtotime($dateNow))."', pass='".$totalScore."', fail='".($totalQuestion - $totalScore)."', score='".($totalScore * 10.)"' WHERE session_id = '".$_SESSION['nim']."'";
				$q = "UPDATE m_tests SET end_date ='".date('H:i:s', strtotime($dateNow))."', pass ='".$totalScore."',  fail ='".($totalQuestion - $totalScore)."', score = '".($totalScore * 10)."' WHERE session_id = '".$_SESSION['nim']."'";
				// var_dump($q); exit;
				mysqli_query($link, $q);
			}

			if (($key = array_search($question, $formula)) !== false) {
				unset($formula[$key]);
			}

			$keyrand  = array_rand($formula, 1);
			$query        = "SELECT q.id, q.question, qa.a,qa.b,qa.c,qa.d FROM m_questions q INNER JOIN question_answers qa ON qa.question_id = q.id WHERE q.id = ".$formula[$keyrand];
			$getData      = mysqli_query($link, $query);
			$data         = mysqli_fetch_assoc($getData);

			$response['qid'] = $data['id'];
			$response['question'] = $data['question'];

			$dice = mt_rand(1,4);
			if ($dice == 1) {
				$response['a'] = $data['a'];
				$response['b'] = $data['d'];
				$response['c'] = $data['b'];
				$response['d'] = $data['c'];
			}
			else if ($dice == 2) {
				$response['a'] = $data['b'];
				$response['b'] = $data['a'];
				$response['c'] = $data['c'];
				$response['d'] = $data['d'];
			}
			else if ($dice == 3) {
				$response['a'] = $data['a'];
				$response['b'] = $data['c'];
				$response['c'] = $data['b'];
				$response['d'] = $data['d'];
			}
			else if ($dice == 4) {
				$response['a'] = $data['c'];
				$response['b'] = $data['d'];
				$response['c'] = $data['a'];
				$response['d'] = $data['b'];
			}


			$response['formula'] = implode(',',$formula);

			echo json_encode($response);
		}