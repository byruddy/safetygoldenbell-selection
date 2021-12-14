<?php  
  include_once('../../config/connection.php');
  include_once('../../config/config.php');
  // Auth
  if(!isset($_SESSION['is_logged_in'])){
    header('Location: '.BASE_URL); exit;
  } elseif(!isset($_SESSION['administrator'])){
    header('Location: '.BASE_URL.'dashboard/practice/readme.php'); exit;
  }

  $sortby       = $_GET['sortby'];
  $primary      = (isset($_GET['primary'])) ? true : false;
  $secondary    = (isset($_GET['secondary'])) ? true : false;
  $occupational = (isset($_GET['occupational'])) ? true : false;
  $disaster     = (isset($_GET['disaster'])) ? true : false;
  $posting      = (isset($_GET['posting'])) ? true : false;

  $sheets = $where = '';
  if($primary == 1){
    $where .= "'primary',";
    $sheets .= 'Primary Safety Quiz#1,';
  } else {
    $sheets .= 'Primary Safety Quiz#0,';
  }
  if($secondary == 1){
    $where .= "'secondary',";
    $sheets .= 'Secondary Safety Quiz#1,';
  } else {
    $sheets .= 'Secondary Safety Quiz#0,';
  }
  if($occupational == 1){
    $where .= "'occupational',";
    $sheets .= 'Occupational Health Quiz#1,';
  } else {
    $sheets .= 'Occupational Health Quiz#0,';
  }
  if($disaster == 1){
    $where .= "'disaster',";
    $sheets .= 'Disaster Prevention#1,';
  } else {
    $sheets .= 'Disaster Prevention#0,';
  }
  if($posting == 1){
    $where .= "'posting',";
    $sheets .= 'Posting Article Quiz#1,';
  } else {
    $sheets .= 'Posting Article Quiz#0,';
  }
  $sheets = substr($sheets, 0,-1);
  $sheets = explode(',', $sheets);
  $where = substr($where, 0,-1);

  $timeStart  = date('H:i:s');

  $query        = "SELECT * FROM m_questions WHERE sheet IN (".$where.")";
  $getData      = mysqli_query($link, $query);

  $i = 1;
  while($row = mysqli_fetch_assoc($getData)){
    $data[$i] = array('id'=>$row['id'],'question'=>$row['question'],'answer'=>$row['answer'],'sheet'=>$row['sheet'],'category'=>$row['category']);
    $diceTemp[$i] = $row['id'];
    $i++;
  }

  if($sortby == 'random'){
    $keyrand  = rand(1, ($i-1));
  } elseif($sortby == 'bysheet'){
    $keyrand  = 1;
  }
  $data['first'] = $data[$keyrand];
  if($data['first']['sheet'] == 'primary'){
    $sheet = 'Primary Safety Quiz';
  } elseif($data['first']['sheet'] == 'secondary'){
    $sheet = 'Secondary Safety Quiz';
  } elseif($data['first']['sheet'] == 'occupational'){
    $sheet = 'Occupational Health Quiz';
  } elseif($data['first']['sheet'] == 'disaster'){
    $sheet = 'Disaster Prevention';
  } elseif($data['first']['sheet'] == 'posting'){
    $sheet = 'Posting Article Quiz';
  }

  for ($j=1; $j < $i; $j++) {
    if ($diceTemp[$j] == $data['first']['id']) {
      unset($diceTemp[$j]);
    }
  }

  $progressValue = ((1/count($diceTemp))*100);

  $his = $sortby.','.str_replace("'", "", $where);

  $group_id = '';
  for ($k=1; $k < $i; $k++) { 
    $group_id .= $data[$k]['id'].'.';
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/favicon.ico">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/b4/css/bootstrap.min.css">
    <!-- Font Awesomee 4 -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fa4/css/font-awesome.min.css">

    <title>Safety PTKP Competition - Tools Remember byruddy</title>
  </head>
  <body>
    <div class="text-center p-1 font-weight-light" style="background-color: #fdcb6e; color:#444">
      PRACTICE MODE
    </div>
    <div class="container">
      <div class="p-3 text-center mb-0">
        <h6>Pass : <b class="text-success" id="countPass">0</b> | Fail : <b class="text-danger" id="countFail">0</b><b class="d-none" id="countRepeat">0</b></h6>
        <hr class="mb-0">
      </div>
    
      <div id="finish" style="display: none;">
        <h1 class="display-4"><span class="text-success"><i class="fa fa-line-chart"></i> Keep Practice!</span></h1>
        <h5 class="font-weight-normal text-muted">Practice has been finish on <?= date('d/m/Y H:i:s'); ?></h5>
        <div class="progress mt-3" style="height: 3px;">
          <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="row mt-3">

          <div class="col-lg-4 mb-3">
            <h6 class="text-center"><i class="fa fa-list-alt"></i> Results of Practice</h6>
            <table class="table table-bordered table-sm mb-4">
              <thead style="background-color: rgba(46, 204, 113,0.2);">
                <tr>
                  <th scope="col" class="text-center font-weight-normal">Pass</th>
                  <th scope="col" class="text-center font-weight-normal">Fail</th>
                  <th scope="col" class="text-center font-weight-normal">Duration</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center text-success font-weight-bold r_countPass">0</td>
                  <td class="text-center text-danger font-weight-bold r_countFail">0</td>
                  <td class="text-center font-weight-bold r_duration">-</td>
                </tr>
              </tbody>
            </table>

            <div class="text-center">
              <h5 class="font-weight-light mb-4"><em>"Keep Practice and Test<br>everytime and everywhere"</em></h5>
              <a class="btn btn-md btn-light" style="border-radius: 3px; border: 1px solid #D2D2D2;" href="<?= BASE_URL ?>dashboard/">Dashboard</a>
              <a class="btn btn-md btn-success text-white" style="border-radius: 3px; border: 1px solid #D2D2D2;" href="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>">Practice Again</a>
            </div>
          </div>
          

          <div class="col-lg-8">
            <h6 class="text-center"><i class="fa fa-refresh"></i> The hardest and most failed questions</h6>
            <hr>
            <ol id="hard_question_list">
              <div class="alert alert-warning" role="alert">Your brain is good condition! Keep practice for Ranking #1</div>
            </ol>
          </div>

        </div>
      </div>

      <div id="quiz_process">
        <div class="text-center mb-2">
          <i class="fa fa-clock-o"></i> <p class="m-0 d-inline" id="duration">00:00:00</p>
          <div class="progress mt-2" style="height: 3px;">
            <div class="progress-bar" id="progressStart" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div id="lookAnswer" style="min-height: 350px;">
          <p class="loader" style="display: none;">Memuat ...</p>
          <small class="text-muted loadData" id="category" style="opacity: 0.7"><?= $sheet; ?></small>
          <p class="lead mb-2 loadData" id="question"><?= $data['first']['question']; ?></p>
          <h5 class="wait-new font-weight-normal" id="answer" style="display: none;background-color: rgba(255, 234, 167,0.7); padding: 15px; margin-top: 10px; border: 1px dotted rgba(253, 203, 110,1.0); border-radius: 4px; color: #444;"><?= $data['first']['answer']; ?></h5>
        </div>
        <hr>
        <div class="row mb-3">
          <div class="col-9">
            <a class="btn btn-md nextNewQuestion loadDataBTN" id="answerPass" style="border-radius: 3px; margin-right: 10px; background-color: #00b894; padding-left: 40px; padding-right: 40px; color: white;" href="#" role="button" action="pass">Pass</a>
            <a class="btn btn-md nextNewQuestion loadDataBTN" id="answerFail" style="border-radius: 3px; margin-left: 10px; background-color: #ff4757; padding-left: 40px; padding-right: 40px;  color: white;" href="#" role="button" action="fail">Fail</a>
          </div>
          <div class="col-3 text-muted font-weight-light text-right">
            <a class="btn btn-md loadDataBTN" id="giveup" style="border-radius: 3px; margin-left: 10px; padding-left: 10px; padding-right: 10px;  color: #444; border-color: #B2B2B2;" role="button"><i class="fa fa-flag"></i></a>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-center">
              <?php  
                for ($i=0; $i < 5; $i++) { 
                  $isCheck = explode('#', $sheets[$i]);
                  if ($i == 0) {
                    echo '<li class="text-muted mr-2 active">'.strtoupper($sortby).' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></li>';
                  }
                  if($isCheck[1] == '1'){
                    echo '<li class="breadcrumb-item"><a href="#" style="cursor: default; text-decoration: none;">'.$isCheck[0].'</a></li>';
                  } else {
                    echo '<li class="breadcrumb-item active" aria-current="page">'.$isCheck[0].'</li>';
                  }
                  if ($i == 4) {
                    echo '<li class="breadcrumb-item"><a href="#"></a></li>';
                  }
                }
              ?>
            </ol>
          </nav>
        </div>
      </div>

    
    </div>
   <div id="bindQTemp" class="d-none"><?= implode($diceTemp, ','); ?></div><br>
   <div id="idQuestion" class="d-none"><?= $data['first']['id']; ?></div><br>
   <div id="bindQFail" class="d-none"></div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= BASE_URL ?>assets/b4/js/jquery-3.4.1.slim.min.js"></script>
    <script src="<?= BASE_URL ?>assets/b4/js/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/b4/js/popper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/b4/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>assets/b4/js/sweetalert.min.js"></script>
    <script src="<?= BASE_URL ?>assets/jquery.stopwatch.js"></script>
    <script>
      $(document).ready(function(){
        // Duration Realtime
        $('#duration').stopwatch().stopwatch('start');
        
        // Functions checking fail is repeat
        function chekInBindQFaiil(bind_arr, id_question){
          var failArray = bind_arr.split(",");

          for(var i = 1; i < failArray.length; i++){
              if (parseInt(failArray[i]) === parseInt(id_question)) {
                return true;
              }
          } 
        }

        // New Question
        var countQuestionProgress = 1;
        $('.nextNewQuestion').click(function(e){
          e.preventDefault();
          $('#duration').stopwatch().stopwatch('stop');
          var action = $(this).attr('action');
          var checkAnswerClick = $('#answer').attr('style').length;
          var idQuestion = $('#idQuestion').text();
          var bindQFail  = $('#bindQFail').text();
          var bindQTemp  = $('#bindQTemp').text();
          // Formula logic
          var formulaSend = $('#bindQTemp').text();
          if (formulaSend == '' && action == 'fail') {
            formulaSend = idQuestion;
          }
          // UX Disable
          $('#answer').css('display', 'none');
          $('.loader').css('display','block');
          $('.loadData').css('display','none');
          $('a.loadDataBTN').css('cursor','no-drop').addClass('disabled').attr('disabled', 'disabled');
          $.get("<?= BASE_URL ?>config/functions/practice_process.php?action=" + action + "&formula=" + formulaSend + "&sortby=<?= $sortby; ?>" + "&sheet_selected=<?= substr($group_id, 0,-1); ?>", function(data) {
              var resp = $.parseJSON(data);
              $('#duration').stopwatch().stopwatch('start');
              console.log(resp);
              if(resp.isFinish){
                $('#quiz_process').css('display', 'none');
                $('#finish').fadeIn();
                $('#duration').stopwatch().stopwatch('stop');            
                $('.r_countPass').text($('#countPass').text());
                $('.r_countFail').text($('#countFail').text());
                $('.r_duration').text($('#duration').text());
                $('#hard_question_list').html(resp.questionList);
                if (action == 'pass' && chekInBindQFaiil(bindQFail, idQuestion) === undefined){
                  $('#countPass').text(parseInt($('#countPass').text())+1);
                }
              } else {
                if(checkAnswerClick == 159){
                  $('#duration').stopwatch().stopwatch('start');
                }
                var passFormula = resp.formula;
                var isProgress = true;
                if (action == 'fail') { // FAIL CONDITION
                  if(bindQFail.length == 0){
                    $('#bindQFail').html(idQuestion);
                  }
                  if (chekInBindQFaiil(bindQFail, idQuestion)) {
                    $('#countRepeat').text(parseInt($('#countRepeat').text())+1);
                    isProgress = false;
                  } else if(chekInBindQFaiil(bindQFail, idQuestion) === undefined) {
                    $('#countFail').text(parseInt($('#countFail').text())+1);
                    $('#bindQFail').html(bindQFail + ',' + idQuestion);
                  }
                  if(passFormula == null){
                    // passFormula = idQuestion;
                  } else {
                    passFormula = passFormula + ',' + idQuestion;
                  } 
                } else if (action == 'pass') { // PASS CONDITION
                  if (chekInBindQFaiil(bindQFail, idQuestion) === undefined) {
                     $.get("<?= BASE_URL ?>config/functions/answer_record.php?mode=practice&id=" + $('#idQuestion').text() + "&answer=1", function(data, status){
                        // console.log(data);
                     });
                    $('#countPass').text(parseInt($('#countPass').text())+1);
                  } else {
                    isProgress = false;
                  }
                }
                $('#category').html(resp.sheet);
                $('#idQuestion').html(resp.id);
                $('#question').html(resp.question);
                $('#answer').html(resp.answer);
                $('#bindQTemp').html(passFormula);
                $('#bindQSelect').html(resp.newSelect);
                // UX Enable
                $('.loader').css('display','none');
                $('.loadData').css('display','block');
                $('a.loadDataBTN').css('cursor','pointer').removeClass('disabled').removeAttr('disabled');
                // Debug
                if (isProgress) {
                  countQuestionProgress++;
                  var runProgress = (countQuestionProgress/<?= count($diceTemp)+1; ?>)*100;
                  if(countQuestionProgress == <?= count($diceTemp)+1; ?>){
                    runProgress = 99;
                  }
                  $('.progress-bar').css('width', runProgress+'%').attr('aria-valuenow', runProgress);
                }
              }
          });
        });

        // Record answer
        $('#answerFail').click(function(e){
           $.get("<?= BASE_URL ?>config/functions/answer_record.php?mode=practice&id=" + $('#idQuestion').text() + "&answer=0", function(data, status){
              // console.log(data);
           });
        });

        // Progress Start
        $('#progressStart').css('width', '<?= $progressValue; ?>%').attr('aria-valuenow','<?= $progressValue; ?>');

        // Show Answer
        $('#lookAnswer').click(function(e){
          $('#answer').fadeIn();
          $('#duration').stopwatch().stopwatch('stop');            
        });

        // Giveup button
        $('#giveup').click(function(e){
          e.preventDefault();
          function click(){
            $('#duration').stopwatch().stopwatch('stop');            
            swal({
              title: "Are you sure?",
              text: "You will be lost results for this practice!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((confirm) => {
              if (confirm) {
                window.location.href = "<?= BASE_URL.'dashboard/practice/readme.php?his='.$his?>";
              } else {
                $('#duration').stopwatch().stopwatch('start');            
                swal("Keep spirit for holiday in KOREA, yeah!");
              }
            });
          }
          var isConfirm = click();
        });

        

      });
    </script>
  </body>
</html>

  
