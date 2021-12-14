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

  // Time Deadline
$dt_end = new DateTime('December 30, 2019 3:00 PM');
$remain = $dt_end->diff(new DateTime());
  // Count Data
$countQ = mysqli_num_rows(mysqli_query($link, "SELECT * FROM m_questions"));
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

        <h1 class="display-4" style="font-size: 40px;"><span class="text-primary">Test,</span> readme</h1>
        <p class="lead mb-4">This test has 100 question and will show question random for you, type answer is multiple choice.<br>for confirm to your answer you can click the answer button. 
          <br><br>1. Pray before click start button.<br>2. 10 seconds for each question<br><span class="font-weight-normal text-danger">3. Don't reload browser while in test.</span></p>
          <?php  
          if(isset($_SESSION['guest_name']) || isset($_SESSION['administrator'])){
            ?>
            <a class="btn btn-lg btn-primary" style="border-radius: 3px;" href="<?= BASE_URL ?>dashboard/test/" role="button"><i class="fa fa-play"></i> Start Now</a>
            <?php  
          } else {
            ?>
            <a class="btn btn-lg setname-scs" style="border-radius: 3px; display: none; background-color: #ff4757; color: white;" href="<?= BASE_URL ?>dashboard/test/" role="button"><i class="fa fa-play"></i> Start Now</a>
            <div class="row box-setname">
              <div class="col-lg-3 col-md-6 mb-2">
                <input class="form-control form-control-lg" id="guestName" type="text" placeholder="Guest Name">
              </div>
              <div class="col-lg-9 col-md-6">
                <a class="btn btn-lg" style="border-radius: 3px; background-color: #ff4757; color: white;" href="<?= BASE_URL ?>dashboard/test/" role="button" id="saveGuestName"><i class="fa fa-user"></i> Save</a>
              </div>
            </div>
            <?php  
          }
          ?>

        </div>

      </div>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="<?= BASE_URL ?>assets/b4/js/jquery-3.4.1.slim.min.js"></script>
      <script src="<?= BASE_URL ?>assets/b4/js/jquery.min.js"></script>
      <script src="<?= BASE_URL ?>assets/b4/js/popper.min.js"></script>
      <script src="<?= BASE_URL ?>assets/b4/js/bootstrap.min.js"></script>
      <script src="<?= BASE_URL ?>assets/b4/js/sweetalert.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
      <script>
        $(document).ready(function(){
          $('#saveGuestName').click(function(e){
            e.preventDefault();
            if ($('#guestName').val() == '') {
              $('#guestName').css('borderColor', 'red');
            } else {
              $.post("<?= BASE_URL; ?>config/functions/guest_setname.php",
              {
                name: $('#guestName').val()
              },
              function(data, status){
                console.log(data);
                if(data == 'success'){
                  swal("Good job!", "Your name has been set!", "success");
                  $('.box-setname').css('display', 'none');
                  $('.setname-scs').fadeIn();

                }
              });    
            }
          });

          $('#guestName').click(function(){
            $(this).css('borderColor', '#D2D2D2');
          });
        });
      </script>
    </body>
    </html>


