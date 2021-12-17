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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="<?= BASE_URL.'assets/bootstrap-5/css/bootstrap.min.css' ?>" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= BASE_URL.'assets/bootstrap-5/font/bootstrap-icons.css' ?>">

    <title>Safety PTKP Competition - Tools Remember byruddy</title>
  </head>
  <body>
    <div class="container py-3">
      <header>
        <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
          <h4><span class="text-muted">POSCO ICT-INDONESIA</span></h4>

          <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
            <a class="py-2 text-dark text-decoration-none" href="#">BETA</a>
          </nav>
        </div>

        <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
          <h1 class="display-4 fw-normal"><span class="text-danger">Safety</span> <span class="text-primary">Golden Bell</span> <i class="bi bi-bell text-warning"></i></h1>
          <p class="fs-5 text-muted"><i>"Safety isn't expensive, it's pricelsss"</i></p>
        </div>
      </header>

      <main>
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
          <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm border-primary">
              <div class="card-header py-3 text-white bg-primary border-primary">
                <h4 class="my-0 fw-normal">Ready to Rock?</h4>
              </div>
              <div class="card-body text-center">
                <div class="py-1 pb-2">
                  <img src="<?= BASE_URL.'assets/img/superman.gif' ?>" width="130">
                  <small class="mb-1 d-block text-muted mt-1"><i>"Learning never exhausts the mind."<br>- Leonardo da Vinci</i></small>
                </div>
                <button type="button" class="w-100 btn btn-lg btn-primary" id="enterRoom">Enter Room</button>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
              <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Event</h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">Maret <small class="text-muted fw-light"> 2022</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                  <li>KP Auditorium</li>
                  <li>400 Participants</li>
                  <li>KP/Partner Finalists: 150</li>
                  <li>Cheering Teams : 250 persons</li>
                </ul>
                <button type="button" class="w-100 btn btn-lg btn-outline-primary cs">Detail</button>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">
              <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Total Questions</h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">50</h1>
                <ul class="list-unstyled mt-3 mb-4">
                  <li>Primary & Secondary Safety</li>
                  <li>Occupational Health</li>
                  <li>Disaaster Prevention</li>
                  <li>Posting Article</li>
                </ul>
                <button type="button" class="w-100 btn btn-lg btn-outline-primary cs">Detail</button>
              </div>
            </div>
          </div>
        </div>
      </main>

      <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <small class="d-block mb-3 text-muted">&copy; 2019–2021</small>
      </footer>
    </div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="<?= BASE_URL.'assets/bootstrap-5/js/bootstrap.bundle.min.js' ?>"></script>
    <!-- jQuery -->
    <script src="<?= BASE_URL.'assets/bootstrap-5/js/jquery.min.js' ?>"></script>
    <!-- SweetAlert -->
    <script src="<?= BASE_URL.'assets/bootstrap-5/js/sweetalert.min.js' ?>"></script>

    <script>
      $(document).ready(function(){

        $(".cs").click(function(){
          swal('Coming soon');
        });

        $('#enterRoom').click(function(){
          swal({
            text: 'Enter your employee ID: ',
            content: {
              element: "input",
              // attributes: {
              //   type: "number"
              // },
            },
            button: {
              text: "Enter",
              closeModal: false,
            },
          })
          .then(id => {
            if (!id) throw null;

            return fetch(`<?= BASE_URL ?>config/functions/auth.php?id=${id}`);
          })
          .then(results => {
            return results.json();
          })
          .then(json => {
            const movie = json.results;
            // console.log(movie);

            if (movie == 'success') {
              window.location.href = "<?= BASE_URL.'dashboard/?ref=welcome' ?>";
            }
            else if (movie == 'failed') {
              swal("Oh noes!", "Your id isn't match in database!", "error");
            }
          });

        });
      });
    </script>

  </body>
  </html>