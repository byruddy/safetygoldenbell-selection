<?php  
include_once('../config/connection.php');
include_once('../config/config.php');
  // Auth
if(isset($_SESSION['is_logged_in'])){
  header('Location: '.BASE_URL.'dashboard'); exit;
}
?>
<!doctype html>
  <html lang="en">
  <head>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/img/favicon.ico">
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
    <div class="container" style="margin-top: 10px;">
      <h6 class="text-center font-weight-light text-muted">Quiz Safety Competition Practice for Selection (Web-based) - made with <code><span style="font-size: 13px;"><i class="fa fa-heart" aria-hidden="true"></i></span></code></h6>
      <hr>

      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <main role="main">
            <section class="text-center mt-1">
              <div class="container">
                <h1 class="mb-0"><span class="text-warning"><i class="fa fa-bell" aria-hidden="true"></i></span><br><span style="color: #ff4757">Safety</span> <span style="color: #3742fa">Golden Bell</span></h1>
                <p class="lead text-muted">Krakatau Posco 2020</p>

                <div class="box-note">

                  <h6 class="m-0">3rd KP CHALLENGE! SAFETY GOLDEN BELL</h6>
                  <small>December 2, 2019 - January 31, 2020</small>
                  <hr class="mb-3">
                  <div class="row">
                    <div class="col-lg-4 text-center">
                      <span class="badge font-weight-light badge-warning text-white">Distribute 300 Questions</span>
                      <p class="m-0" style="font-size: 12px; line-height: 15px;">Preparation,<br>Selft-Learning<br><span class="text-info font-weight-bold">(December 2 - 31, 2019)</span></p>
                    </div>
                    <div class="col-lg-4 text-center">
                      <span class="badge font-weight-light badge-primary text-white">Select KP, Partner Finalists</span>
                      <p class="m-0" style="font-size: 12px; line-height: 15px;">Preliminary Round<br><span class="text-info font-weight-bold">(January 6 - 18, 2020)</span></p>
                    </div>
                    <div class="col-lg-4 text-center">
                      <span class="badge font-weight-light badge-success text-white">150 Finalist</span>
                      <p class="m-0" style="font-size: 12px; line-height: 15px;">Final Round<br><span class="text-info font-weight-bold">(One Day of<br>January 27-31, 2020)</span></p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 mt-4 text-left">
                      <p class="text-info font-weight-bold mb-1">Final Round</p>
                      <table style="font-size: 12px;" width="100%">
                        <tr>
                          <td width="30">Schedule</td>
                          <td width="5">:</td>
                          <td width="65">January 29, 2020 (Tentative), 13:30 - 17:00</td>
                        </tr>
                        <tr>
                          <td>Place</td>
                          <td>:</td>
                          <td>KP Auditorium</td>
                        </tr>
                        <tr>
                          <td>Attendees</td>
                          <td>:</td>
                          <td><span class="text-info font-weight-bold">Total 400 Participants</span></td>
                        </tr>
                        <tr>
                          <td></td><td></td><td>(KP/Partner Finalists: 150 (Production Division), Cheering Teams : 250 persons)</td>
                        </tr>
                      </table>
                      <p class="m-0 text-center text-muted mt-2" style="font-size: 12px;">Help Contact : Ext. **** - A***da* U*** **m* (*** Team)</p>
                    </div>
                  </div>
                  
                </div>
                
                <hr class="mb-0">

                <div class="row">
                  <div class="col-lg-6 offset-lg-3">
                    <div class="box-gotodashboard text-center mt-2">
                     <div class="form-group">
                      <h6 class="text-success"><i class="fa fa-clock-o" aria-hidden="true"></i> Let's Pratice</h6>
                      <input type="password" class="form-control form-control-sm text-center" id="enterPassword" placeholder="Enter Password">
                      <small id="emailHelp" class="form-text text-muted">as <a href="<?= BASE_URL ?>config/functions/guest.php" class="text-info">guest</a> with some features.</small>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </section>
        </main>
      </div>
    </div>



  </div>
  <p id="answer" class="d-none"><?= $data['answer']; ?></p>
  <p id="no_sort" class="d-none">0</p>
  <p id="sort_limit" class="d-none"></p>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="<?= BASE_URL ?>assets/b4/js/jquery-3.4.1.slim.min.js"></script>
  <script src="<?= BASE_URL ?>assets/b4/js/jquery.min.js"></script>
  <script src="<?= BASE_URL ?>assets/b4/js/popper.min.js"></script>
  <script src="<?= BASE_URL ?>assets/b4/js/bootstrap.min.js"></script>
  <script src="<?= BASE_URL ?>assets/b4/js/sweetalert.min.js"></script>
  <script>
    $(document).ready(function(){
        // Authentication process
        $('#enterPassword').keyup(function(e){
          if(e.keyCode == 13){
            $('#enterPassword').addClass('disabled').attr('disabled', 'disabled');
            $.post("<?= BASE_URL ?>config/functions/auth.php",{
              password: $('#enterPassword').val()
            },
            function(data, status){
              console.log("Data: " + data + "\nStatus: " + status);
              $('#enterPassword').removeClass('disabled').removeAttr('disabled');
              if(data =='fail'){
                $('#enterPassword').css('borderColor', '#ff4757');
                $('#enterPassword').select();
              } else if (data == 'success'){
                alert('Well done! You successfully logged in to practice quiz dashboard');
                window.location.href = "<?= BASE_URL.'dashboard/?ref=welcome' ?>";
              }
            });
          }
        });
        $('#enterPassword').click(function(){
          $(this).css('borderColor', '#D2D2D2');
        });
      });
    </script>
  </body>
  </html>

  
