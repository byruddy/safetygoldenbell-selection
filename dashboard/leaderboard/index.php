<?php  
include_once('../../config/connection.php');
include_once('../../config/config.php');

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
$graphPass = $graphFail = [];
$query  = "SELECT * FROM m_tests WHERE session_id = '111105' ORDER BY id DESC LIMIT 10";
$data10 = mysqli_query($link, $query);
while ($row = mysqli_fetch_assoc($data10)) {
  $graphPass[] = '#'.$row['id'].'='.$row['pass'];
  $graphFail[] = '#'.$row['id'].'='.$row['fail'];
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
      <h5 class="my-0 mr-md-auto font-weight-light"><a href="<?= BASE_URL; ?>dashboard" class="text-primary title-dashboard"><span class="font-weight-normal">POSCO ICT-INDONESIA</span></a></h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-muted" href="<?= BASE_URL ?>dashboard/about.php"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
      </nav>
      <a class="btn btn-outline-danger btn-sm" href="<?= BASE_URL ?>config/functions/signout.php">Sign Out</a>
    </div>
    
    <div class="container">

      <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto">
        <h1 class="display-4 text-center"><span class="text-primary">Leaderboard</span></h1>
      </h1>
      <hr>
      <table class="table table-sm table-bordered mt-3">
        <thead class="table-primary">
          <tr>
            <th scope="col" class="text-center">#</th>
            <th scope="col">Fullname</th>
            <th scope="col" class="text-center">Benar</th>
            <th scope="col" class="text-center">Salah</th>
            <th scope="col" class="text-center">Duration(s)</th>
            <th scope="col" class="text-center">Score</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $runSql = mysqli_query($link, "SELECT p.nim, p.fullname, t.pass, t.fail, t.duration, t.score FROM m_tests t INNER JOIN participants p ON t.session_id = p.nim ORDER BY t.score DESC, duration ASC");
          $i = 1;
          while ($row = mysqli_fetch_assoc($runSql)) {

            if ($row['nim'] == $_SESSION['nim']) {
              echo '<tr style="background-color: #ffda79">';
            } else {
              echo '<tr>';
            }
            ?>
            <th scope="row" class="text-center"><?= $i ?></th>
            <td><?= $row['fullname'] ?></td>
            <td class="text-center"><?= $row['pass'] ?></td>
            <td class="text-center"><?= $row['fail'] ?></td>
            <td class="text-center"><?= $row['duration'] ?></td>
            <td class="text-center"><?= $row['score'] ?></td>
          </tr>
          <?php 
          $i++;
        }
        ?>
      </tbody>
    </table>
    <small class="text-muted">This application is open-source, you can see algorithm of tests <a href="https://github.com/byruddy/safetygoldenbell-selection" class="text-info" target="_blank">[github/byruddy]</a></small>
    <br><br><br><br>

  </div>

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


