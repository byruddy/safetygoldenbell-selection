<?php  
include_once('../config/connection.php');
include_once('../config/config.php');

  // Auth
if(!isset($_SESSION['is_logged_in'])){
  header('Location: '.BASE_URL); exit;
}

  // Count Data
if (isset($_SESSION['administrator'])) {
  $user = '111105';
  $countQ = mysqli_num_rows(mysqli_query($link, "SELECT * FROM m_questions"));
} else {
  $user = $_SESSION['guest'];
  $countQ = 'ON PROGRESS';
}
$countT = mysqli_num_rows(mysqli_query($link, "SELECT * FROM m_tests WHERE session_id ='".$user."'"));
$countG = mysqli_num_rows(mysqli_query($link, "SELECT * FROM m_guests"));
  // Graph Data
$query  = "SELECT * FROM participants WHERE nim = '".$_SESSION['nim']."'";
$data10 = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($data10);
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
      <h5 class="my-0 mr-md-auto font-weight-light"><a href="<?= BASE_URL; ?>dashboard" class="text-primary title-dashboard"><span class="font-weight-normal">POSCO ICT-INDONESIA</span></a></h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-muted" href="<?= BASE_URL ?>dashboard/about.php"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
      </nav>
      <a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>config/functions/signout.php">Sign Out</a>
    </div>
    
    <div class="container">

      <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Hi <?= $user['fullname'] ?>, <span style="color: #ff4757">Calon Peserta</span> <span class="text-primary">Golden Bell 2022</span></h1>
      </h1>
      <p class="lead mb-4">This application make you remember question more fast, <b style="color: #ff4757">Test</b> Now will be results for questions random,<br>because Quiz will be system like <span class="text-warning">Ranking 1st</span> in Indonesia<br>Practice make you manage question good for remember. Pray before Fighting</p>

      <?php 
      $query2        = "SELECT * FROM test_logs WHERE participant_id = '".$_SESSION['nim']."' LIMIT 1";
      $getData2      = mysqli_query($link, $query2);
      $check = mysqli_num_rows($getData2);
      if ($check == 0) {
        ?>
        <a class="btn btn-lg" style="border-radius: 3px; background-color: #ff4757; color: white;" href="<?= BASE_URL ?>dashboard/test/readme.php" role="button">Test Now</a>
        <?php 
      }
      ?>
      <a class="btn btn-lg" style="border-radius: 3px; background-color: #00b894; color: white;" href="<?= BASE_URL ?>dashboard/leaderboard/" role="button">Leaderboard</a>

      <br><br><br><br>

    </div>
    
    <footer class="pt-2 my-md-5 pt-md-5 border-top">
      <div class="row">
        <div class="col-12 col-md">
          <small class="d-block mb-3 text-muted">Supported by <a href="http://poscoictindonesia.co.id/" style="color: #3742fa;" target="_blank">POSCO ICT-Indonesia</a> and Code <span style="color: #ff4757">byruddy - 113423</span> &copy; 2019–2021</small>
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
</body>
</html>


