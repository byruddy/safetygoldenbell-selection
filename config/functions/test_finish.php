<?php 
  include_once('../connection.php');
  include_once('../config.php');

  // Auth
  if(!isset($_SESSION['is_logged_in'])){
    header('Location: '.BASE_URL); exit;
  }
  $test_date	 	= date('Y/m/d');
  $start_date	 	= mysqli_real_escape_string($link, $_POST['timeStart']);
  $end_date		  = mysqli_real_escape_string($link, $_POST['finishStart']);
  $pass		  		= mysqli_real_escape_string($link, $_POST['pass']);
  $fail		  		= mysqli_real_escape_string($link, $_POST['fail']);
  $repeat		  	= mysqli_real_escape_string($link, $_POST['repeat']);
  $duration			= mysqli_real_escape_string($link, $_POST['duration']);

  if (isset($_SESSION['administrator'])) {
  	$user = '111105';
  } else {
  	$user = $_SESSION['guest'];
  }

  $sql = "INSERT INTO m_tests VALUES(NULL, '".$test_date."', '".$start_date."','".$end_date."','".$pass."','".$fail."','".$repeat."','".$duration."','".$user."')";
	if (mysqli_query($link, $sql)) {
	    $id 	= mysqli_insert_id($link);
			$data['id'] = $id;

			$query 			= "SELECT * FROM m_tests WHERE session_id = '".$user."' ORDER BY pass DESC, duration ASC LIMIT 10";
			$data10	= mysqli_query($link, $query);
			$top10Test = '';
			$i = 1;
			while ($row = mysqli_fetch_assoc($data10)) {
				// $top10Test[$i] = array('date'=>$test_date,'duration'=>$row['duration'],'not'=>$row['id']);
				$top10Test .= '<tr ';
				if ($row['id'] == $id) {
					$top10Test .= 'style="background-color: #fcf8e3"';
				}
				$top10Test .= '><th scope="row" class="text-center">'.$i.'</th><td class="text-center">'.date('d/m/Y',strtotime($row['test_date'])).'</td><td class="text-center">'.$row['pass'].'</td><td class="text-center">'.$row['fail'].'</td><td class="text-center">'.$row['duration'].'</td><td class="text-center">#'.$row['id'].'</td></tr>';
				$i++;
			}
			$data['top10'] = $top10Test;
		  echo json_encode($data);
	} else {
	    echo "Error updating record: " . mysqli_error($link);
	}