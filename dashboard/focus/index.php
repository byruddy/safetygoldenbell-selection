<?php  
  include_once('../../config/connection.php');
  include_once('../../config/config.php');
  // Auth
  if(!isset($_SESSION['is_logged_in'])){
    header('Location: '.BASE_URL); exit;
  } elseif(!isset($_SESSION['administrator'])){
    header('Location: '.BASE_URL.'dashboard/practice/readme.php'); exit;
  } elseif (!isset($_GET['id'])) {
    header('Location: '.BASE_URL.'dashboard'); exit;
  }

  $query        = "SELECT * FROM m_questions WHERE id= ".$_GET['id'];
  $getData      = mysqli_query($link, $query);
  $data         = mysqli_fetch_assoc($getData);

  $sheets = '';
  if('primary' == $data['sheet']){
    $sheets .= 'Primary Safety Quiz';
  } else if('secondary' == $data['sheet']){
    $sheets .= 'Secondary Safety Quiz';
  } else if('occupational' == $data['sheet']){
    $sheets .= 'Occupational Health Quiz';
  } else if('disaster' == $data['sheet']){
    $sheets .= 'Disaster Prevention';
  } else if('posting' == $data['sheet']){
    $sheets .= 'Posting Article Quiz';
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
    <div class="text-center p-1 font-weight-light" style="background-color: #34495e; color:white">
      FOCUS MODE
    </div>
    <div class="container">

        <div id="lookAnswer" style="min-height: 350px;">
          <br><br>
          <p class="loader" style="display: none;">Memuat ...</p>
          <small class="text-muted loadData" id="category" style="opacity: 0.7"><?= $sheets; ?></small>
          <p class="lead mb-2 loadData" id="question" style="letter-spacing: 1px;"><?= $data['question']; ?></p>
          <h5 class="wait-new font-weight-normal" id="answer" style=" display: none;background-color: rgba(255, 234, 167,0.7); padding: 15px; margin-top: 10px; border: 1px dotted rgba(253, 203, 110,1.0); border-radius: 4px; color: #444;"><?= $data['answer']; ?></h5>
        </div>
        <hr>
        <div class="row mb-3">
          <div class="col-9">
            <a class="btn btn-md repeatButton loadDataBTN disabled" id="answerPass" style="border-radius: 3px; margin-right: 10px; background-color: #34495e; padding-left: 80px; padding-right: 80px; color: white;" href="#" role="button" disabled="disabled">Repeat</a>
          </div>
          <div class="col-3 text-muted font-weight-light text-right">
            <a class="btn btn-md loadDataBTN" style="border-radius: 3px; margin-left: 10px; padding-left: 10px; padding-right: 10px;  color: #444; border-color: #B2B2B2;" role="button" href="<?= BASE_URL ?>dashboard/"><i class="fa fa-dashboard"></i></a>
          </div>
        </div>

    </div>
    
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
        // Repeat Button
        $('.repeatButton').click(function(e){
          $('.loader').css('display','block');
          $('.loadData').css('display','none');
          $('#answer').css('display', 'none');
          $('a.loadDataBTN').css('cursor','no-drop').addClass('disabled').attr('disabled', 'disabled');
          setTimeout(function(){
            $('.loader').css('display','none');
            $('.loadData').css('display','block');
          }, 1000);
        });

        // Show Answer
        $('#lookAnswer').click(function(e){
          $('#answer').slideToggle();
          $('a.loadDataBTN').css('cursor','pointer').removeClass('disabled').removeAttr('disabled');
        });

      });
    </script>
  </body>
</html>

  
