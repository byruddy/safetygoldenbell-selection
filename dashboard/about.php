<?php  
include_once('../config/connection.php');
include_once('../config/config.php');

$sql    = "SELECT formula FROM app_config";
$result = mysqli_query($link, $sql);
$data   = mysqli_fetch_assoc($result);
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
      .title-dashboard:hover {
        text-decoration: none;
      }
    </style>
    <title>Safety PTKP Competition - Tools Remember byruddy</title>
  </head>
  <body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
      <h5 class="my-0 mr-md-auto font-weight-light"><a href="<?= BASE_URL; ?>dashboard" class="text-primary title-dashboard"><span class="font-weight-normal">POSCO ICT-INDONESIA</span></a></h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-muted" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
      </nav>
      <a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>config/functions/signout.php">Sign Out</a>
    </div>
    
    <div class="container">
      <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto">

        <h3 class="font-weight-normal mb-4 text-center">About</h3>
        <div class="row">
          <div class="col-lg-10 offset-lg-1">
            <hr>
            <p>This application was made within 1 days due to time constraints, therefore if there are bugs in the application,<br>report it <a href="mailto:rdd@posco.net">rdd@posco.net</a></p>
            <h4>Thanks to</h4>
            <div class="row">
              <div class="col text-left">
                <img src="<?= BASE_URL ?>assets/img/ptkp.jpg" alt="PT Krakatau POSCO Logo" width="200">
                <img src="<?= BASE_URL ?>assets/img/ict.jpg" alt="POSCO ICT-Indonesia Logo" width="150">
              </div>
            </div>
            <div class="row">
              <div class="col">
                <img src="<?= BASE_URL ?>assets/img/b4.png" alt="Bootstrap 4 Logo" width="150" style="display: inline-block; margin-bottom: 20px;">
                <img src="<?= BASE_URL ?>assets/img/jquery.jpg" alt="Jquery 3 Logo" width="152" style="display: inline-block; margin-bottom: 20px;">
                <img src="<?= BASE_URL ?>assets/img/fa.png" alt="Font Awesome 4 Logo" width="160" style="display: inline-block; margin-bottom: 20px;">
              </div>
            </div>
          </div>
        </div>

      </div>
      
      <footer class="pt-2 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <small class="d-block mb-3 text-muted">Supported by <a href="http://poscoictindonesia.co.id/" style="color: #3742fa;" target="_blank">POSCO ICT-Indonesia</a> and Code  <span style="color: #ff4757">byruddy - 111105</span> &copy; 2019</small>
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
    <script src="<?= BASE_URL ?>assets/chartjs/2.8.0.js"></script>
    <script>
      $(document).ready(function(){

      });
    </script>
  </body>
  </html>

  
