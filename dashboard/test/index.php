<?php  
include_once('../../config/connection.php');
include_once('../../config/config.php');
  // Auth
if(!isset($_SESSION['is_logged_in'])){
  header('Location: '.BASE_URL); exit;
}

$query2        = "SELECT * FROM test_logs WHERE participant_id = '".$_SESSION['nim']."' LIMIT 1";
$getData2      = mysqli_query($link, $query2);
$check = mysqli_num_rows($getData2);
if ($check > 0) {
  header('Location: '.BASE_URL.'/dashboard'); exit;
}

$timeStart  = date('H:i:s');

if(isset($_SESSION['administrator'])){
  $formula    = mysqli_fetch_assoc(mysqli_query($link, "SELECT formula FROM app_config"))['formula'];
} else {
  $formula  = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30';  
}

  // Inject formula
$formula = "";
$runSql = mysqli_query($link, "SELECT * FROM m_questions WHERE id IN (SELECT question_id FROM question_answers)");
while ($row = mysqli_fetch_assoc($runSql)) {
  $formula .= $row['id'].',';
}

$formula = substr($formula, 0,-1);

$diceTemp   = explode(',', $formula);
$keyrand    = array_rand($diceTemp, 1);
shuffle($diceTemp);

$diceSelect = $diceTemp[$keyrand];

// var_dump($keyrand); exit;

$query        = "SELECT * FROM m_questions WHERE id = ".$diceTemp[$keyrand];
$getData      = mysqli_query($link, $query);

// if ($getData) {
//   echo "Error: " . $sql . "<br>" . mysqli_error($link);
// }

$data         = mysqli_fetch_assoc($getData);


$progressValue = ((1/count($diceTemp))*100);
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

    <style>
        /*a:active,*/
        /*a:visited {*/
            /*background-color: #F8F9FA !important; */
            
        /*}*/
        a, a:visited, a:hover, a:active {
          color: inherit;
          background-color: #F8F9FA !important; 
        }
    </style>
    <title>Safety PTKP Competition - Tools Remember byruddy</title>
  </head>
  <body>
    <div class="text-center p-1 font-weight-light" style="background-color: #0984e3; color:white">
      TEST OF SELECTION IN PC TEAM
    </div>
    <div class="container mt-3">
      <div id="finish" style="display: none;">
        <h5 class="font-weight-normal text-muted">Congratulations! your test has been submitted.</h5>
        <div class="progress mt-3" style="height: 3px;">
          <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-12 mb-3">
            <h6 class="text-center"><i class="fa fa-list-alt"></i> Results of <span class="text-primary"><?= $_SESSION['nim'] ?></span></h6>
            <table class="table table-bordered table-sm mb-4">
              <thead style="background-color: rgba(46, 204, 113,0.2);">
                <tr>
                  <th scope="col" class="text-center font-weight-normal">Date Test</th>
                  <th scope="col" class="text-center font-weight-normal">Start Test</th>
                  <th scope="col" class="text-center font-weight-normal">Finish Test</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center r_date"><?= date('d/m/Y'); ?></td>
                  <td class="text-center r_timeStart">00:00:00</td>
                  <td class="text-center r_timeFinish">00:00:00</td>
                </tr>
              </tbody>
              <thead style="background-color: rgba(46, 204, 113,0.2);">
                <tr>
                  <th scope="col" class="text-center font-weight-normal">Pass</th>
                  <th scope="col" class="text-center font-weight-normal">Fail</th>
                  <th scope="col" class="text-center font-weight-normal">Score</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center text-success font-weight-bold pass">0</td>
                  <td class="text-center text-danger font-weight-bold fail">0</td>
                  <td class="text-center r_durartion font-weight-bold score">0</td>
                </tr>
              </tbody>
            </table>

            <div class="text-center">
              <a class="btn btn-md btn-block btn-light" style="border-radius: 3px; border: 1px solid #D2D2D2;" href="<?= BASE_URL ?>dashboard/leaderboard">Leaderboard</a>
            </div>

          </div>
        </div>
      </div>
      
      <div id="quiz_process" style="display: nonae;">
        <div class="text-center mb-2">
          <h6 class="countdownp">Sisa Waktu Anda : <b class="text-success" id="countdown">10</b></h6>
        </div>
        <div class="text-center mb-2">
          <div class="progress mt-2" style="height: 5px;">
            <div class="progress-bar" id="progressStart" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
        <div id="lookAnswer" style="min-height: 350px;">
          <p class="loader" style="display: none;">Memuat ...</p>
          <small class="text-muted loadData" id="category" style="opacity: 0.7">Primary Safety Quiz</small>
          <p class="lead mb-4 loadData" id="question" qid="<?= $data['id']; ?>"><?= $data['question']; ?></p>

          <?php  
          $query2     = "SELECT * FROM question_answers WHERE question_id = ".$data['id'];
          $getDataMC  = mysqli_query($link, $query2);
          $choice     = mysqli_fetch_assoc($getDataMC);
          

          echo '<a class="btn btn-md btn-block mt-3 btn-light choiceAnswer" id="choice_a" style="border: 1px solid #D2D2D2; display: noneA;" href="#" role="button" action="pass">'.$choice['a'].'</a>';
          echo '<a class="btn btn-md btn-block mt-5 btn-light choiceAnswer" id="choice_b" style="border: 1px solid #D2D2D2; display: noneA;" href="#" role="button" action="pass">'.$choice['b'].'</a>';
          echo '<a class="btn btn-md btn-block mt-5 btn-light choiceAnswer" id="choice_c" style="border: 1px solid #D2D2D2; display: noneA;" href="#" role="button" action="pass">'.$choice['c'].'</a>';
          echo '<a class="btn btn-md btn-block mt-5 btn-light choiceAnswer" id="choice_d" style="border: 1px solid #D2D2D2; display: noneA;" href="#" role="button" action="pass">'.$choice['d'].'</a>';
          ?>

          <h5 class="wait-new font-weight-normal" id="answer" style="display: none;background-color: rgba(255, 234, 167,0.7); padding: 15px; margin-top: 10px; border: 1px dotted rgba(253, 203, 110,1.0); border-radius: 4px; color: #444;"><?= $data['answer']; ?></h5>
          <br><br><br><br><br><br><br>
        </div>
      </div>

      <div id="saving_answer" style="display: none">
        <i>Please wait, saving your answer..</i>
      </div>

    </div>
    <div id="process" class="d-none">true</div>
    <div id="bindQTemp" class="d-none"><?= implode($diceTemp,','); ?></div>
    <div id="timeStart" class="d-none"><?= $timeStart; ?></div>
    <div id="idQuestion" class="d-none"><?= $data['id']; ?></div>
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

        window.onbeforeunload = function(event)
        {
          return confirm("Confirm refresh");
        };

        // Countdown
        function test(choice = null){
        };
        // test();

        var is_finish = false;
        var counter = 10;

        setInterval(function() {

        // if ($('#countdown').text() == '-') {
        //     $('#countdown').text('10');
        //     clearInterval(counter);
        // }

        counter--;
        if (counter >= 0) {
          span = document.getElementById("countdown");
          span.innerHTML = counter;
        }

        if (counter == 10) {
          $('.choiceAnswer').show();
        }

        if (counter <= 5 && counter > 0) {
          $('#countdown').removeClass('text-success');
          $('#countdown').addClass('text-danger');
        }
        // Display 'counter' wherever you want to display it.
        if (counter === 0) {
          $('#countdown').text('10');
          $('#countdown').removeClass('text-danger');
          $('#countdown').addClass('text-success');
          if (!is_finish) {
            next(false);
          }
          clearInterval(counter);
        }

      }, 1000)

        $('.choiceAnswer').click(function(e){
         e.preventDefault();
         var answer = $(this).text();
         next(answer);
       });

        var countQuestionProgress = 1;
        var formula = "<?= implode(",", $diceTemp); ?>";
        <?php unset($diceTemp[$keyrand]);  ?>

        // Next
        function next(answer){
          $('.choiceAnswer').css('background-color','#F8F9FA');
          //$('.choiceAnswer').hide();
          
          clearInterval(counter);
          counter = 11;
          $('#countdown').text('10');
          $('#countdown').removeClass('text-danger');
          $('#countdown').addClass('text-success');
          $('#quiz_process').hide();
          $('#saving_answer').show();
          $.post("<?= BASE_URL ?>config/functions/save_answer.php",
          {
            question_id: $('#question').attr('qid'),
            answer : answer,
            formula : formula
          }, function(response) {
            $('#saving_answer').hide();
            var resp = $.parseJSON(response);

            if (resp.status == 'finish') {
              is_finish = true;
              $('.r_timeStart').text(resp.r_timeStart);
              $('.r_timeFinish').text(resp.r_timeFinish);
              $('.pass').text(resp.pass);
              $('.fail').text(resp.failed);
              $('.score').text(resp.score);

              $('#finish').show();
            } else {
              $('#quiz_process').show();
              //$('.choiceAnswer').hide();
              $("#question").html(resp.question);
              $('#question').attr('qid', resp.qid);
              $('#choice_a').text(resp.a);
              $('#choice_b').text(resp.b);
              $('#choice_c').text(resp.c);
              $('#choice_d').text(resp.d);
              formula = resp.formula;


              countQuestionProgress++;
              var runProgress = (countQuestionProgress/<?= count($diceTemp)+1; ?>)*100;
              if(countQuestionProgress == <?= count($diceTemp)+1; ?>){
                runProgress = 99;
              }
              $('.progress-bar').css('width', runProgress+'%').attr('aria-valuenow', runProgress);
                // console.log(resp);
                // test();
              }

            });
        }

        
    
        $('.countdownp').click(function(){
          if ($('#countdown').text() == '10'){
            $('.choiceAnswer').show(); 
            clearInterval(counter);
            counter = 21;
          }
        });
        
        
        // Show Answer
        function showAnswer(){
          $('#answer').fadeIn();
        }


      });
    </script>
  </body>
  </html>

  
