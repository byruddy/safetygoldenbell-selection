<?php  
  include_once('../../config/connection.php');
  include_once('../../config/config.php');
  // Auth
  if(!isset($_SESSION['is_logged_in'])){
    header('Location: '.BASE_URL); exit;
  }
  // Count by type
  $countPrimary = mysqli_num_rows(mysqli_query($link, "SELECT id FROM m_questions WHERE sheet ='primary'"));
  $countSecondary = mysqli_num_rows(mysqli_query($link, "SELECT id FROM m_questions WHERE sheet ='secondary'"));
  $countOccupational = mysqli_num_rows(mysqli_query($link, "SELECT id FROM m_questions WHERE sheet ='occupational'"));
  $countDisaster = mysqli_num_rows(mysqli_query($link, "SELECT id FROM m_questions WHERE sheet ='disaster'"));
  $countPosting = mysqli_num_rows(mysqli_query($link, "SELECT id FROM m_questions WHERE sheet ='posting'"));

  // Data his
  $hisCheck = array(false,false,false,false,false);
  if(isset($_GET['his'])){
    $his = explode(',', $_GET['his']);
    for ($i=1; $i < count($his); $i++) { 
      if ($his[$i] == 'primary') {
        $hisCheck[0] = true;
      } 
      if ($his[$i] == 'secondary') {
        $hisCheck[1] = true;
      }
      if ($his[$i] == 'occupational') {
        $hisCheck[2] = true;
      }
      if ($his[$i] == 'disaster') {
        $hisCheck[3] = true;
      }
      if ($his[$i] == 'posting') {
        $hisCheck[4] = true;
      }
    }
  } else {
    $his = NULL;
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
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-light"><a href="<?= BASE_URL; ?>dashboard" class="text-primary title-dashboard"><span class="font-weight-normal">Dashboard</span></a></h5>
      <nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2 text-muted" href="<?= BASE_URL ?>dashboard/about.php"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
      </nav>
      <a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>config/functions/signout.php">Sign Out</a>
    </div>
    
    <div class="container">
      <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto">

        <h1 class="display-4"><span style="color: #00b894;">Practice,</span> How it works ?</h1>
        <p class="lead mb-4">This practice will show question by your checkbox at sheet, when question you first you read and say in you heart. <mark>No typing because waste the time</mark>, for confirm to your answer you can click question text area or top at button Pass and Fail.</p>
        

        <p class="text-muted"><b>Configuration Get Question</b></p>
        <div id="box-config mb-4">
          <form action="<?= BASE_URL ?>dashboard/practice/" method="get">
            <div class="opsiSort mb-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input reset-sort" type="radio" name="sortby" id="checkRandom" value="random" checked>
                <label class="form-check-label reset-sort" for="checkRandom" <?= ($his[0] == 'random') ? 'checked' : ''; ?>>Random</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input reset-sort-cst" type="radio" name="sortby" id="checkSort" <?= ($his[0] == 'bysheet') ? 'checked' : ''; ?> value="bysheet">
                <label class="form-check-label reset-sort-cst" for="checkSort">Sort <span class="text-muted">(by number in Excel)</span></label>
              </div>
            </div>
            <div class="filter">
              <div class="form-check form-check-inline">
                <input class="form-check-input reset-sort" type="checkbox" id="checkPrimary" name="primary" value="1" <?php if(!isset($_GET['his']) OR $hisCheck[0] === true){ echo 'checked'; } ?>>
                <label class="form-check-label reset-sort" for="checkPrimary">Primary Safety (<?= $countPrimary; ?>)</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input reset-sort" type="checkbox" id="checkSecondary" name="secondary" value="1" <?php if(!isset($_GET['his']) OR $hisCheck[1] === true){ echo 'checked'; } ?>>
                <label class="form-check-label reset-sort" for="checkSecondary">Secondary Safety (<?= $countSecondary; ?>)</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input reset-sort" type="checkbox" id="checkOccupational" name="occupational" value="1" <?php if(!isset($_GET['his']) OR $hisCheck[2] === true){ echo 'checked'; } ?>>
                <label class="form-check-label reset-sort" for="checkOccupational">Occupational Health (<?= $countOccupational; ?>)</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input reset-sort" type="checkbox" id="checkDisaster" name="disaster" value="1" <?php if(!isset($_GET['his']) OR $hisCheck[3] === true){ echo 'checked'; } ?>>
                <label class="form-check-label reset-sort" for="checkDisaster">Disaster Prevention (<?= $countDisaster; ?>)</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input reset-sort" type="checkbox" id="checkPosting" name="posting" value="1" <?php if(!isset($_GET['his']) OR $hisCheck[4] === true){ echo 'checked'; } ?>>
                <label class="form-check-label reset-sort" for="checkPosting">Posting Article (<?= $countPosting; ?>)</label>
              </div>
            </div>
        </div>


        <button type="submit" class="btn btn-lg mt-3" id="start" style="display: inline-block; border-radius: 3px; background-color: #00b894; color: white;" role="button"><i class="fa fa-play"></i> Start Now</button>
        </form>

      </div>
    
      <footer class="pt-2 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <small class="d-block mb-3 text-muted">Supported by <a href="http://poscoictindonesia.co.id/" style="color: #3742fa;" target="_blank">POSCO ICT-Indonesia</a> and Code by <span style="color: #ff4757">rdd - 111105</span> &copy; 2019</small>
          </div>
        </div>
      </footer>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= BASE_URL ?>assets/b4/js/jquery-3.4.1.slim.min.js"></script>
    <script src="<?= BASE_URL ?>assets/b4/js/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/b4/js/popper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/b4/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>assets/b4/js/sweetalert.min.js"></script>
    <script>
      $(document).ready(function(){
        $('#start').click(function(e){
          <?php  
            if(isset($_SESSION['administrator'])){
          ?>
            var primary       = $('#checkPrimary:checked').val();
            if(primary == '1'){ primary = 1; } else { primary = 0; }

            var secondary     = $('#checkSecondary:checked').val();
            if(secondary == '1'){ secondary = 1; } else { secondary = 0; }

            var occupational = $('#checkOccupational:checked').val();
            if(occupational == '1'){ occupational = 1; } else { occupational = 0; }

            var disaster     = $('#checkDisaster:checked').val();
            if(disaster == '1'){ disaster = 1; } else { disaster = 0; }

            var posting      = $('#checkPosting:checked').val();
            if(posting == '1'){ posting = 1; } else { posting = 0; }

            if(primary == '0' && secondary == '0' && occupational == '0' && disaster == '0' && posting == '0'){
              e.preventDefault();
              swal("Terjadi kesalahan!", "Check (min. 1) Sheet Pertanyaan!", "error");
            }
          <?php 
          } else {
          ?>
          e.preventDefault();
            swal("Sorry!", "You don't have a permission as guest", "error");
          <?php
          }
          ?>
        });
      });
    </script>
  </body>
</html>

  
