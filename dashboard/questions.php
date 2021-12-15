<?php  
include_once('../config/connection.php');
include_once('../config/config.php');
error_reporting(0);

$q_id = $_GET['q'];
$a = $_GET['a'];
$b = $_GET['b'];
$c = $_GET['c'];
$d = $_GET['d'];

if (count($_GET) == 5) {

  $sql = "INSERT INTO question_answers VALUES (".$q_id.", '".$a."','".$b."','".$c."','".$d."')";

    if (mysqli_query($link, $sql)) {
      echo "New record created successfully";
      header('Location: questions.php');
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }
  }
  ?>

  <!doctype html>
    <html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

      <title>Hello, world!</title>
    </head>
    <body>

      <div class="row justify-content-center">
        <div class="col-8">
          
          <h1 class="mt-5">INPUT DATA!</h1>

          <form action="">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Pertanyaan</label>
              <select class="form-select" name="q" aria-label="Default select example">
                <?php 
                $runSql = mysqli_query($link, "SELECT * FROM m_questions WHERE id NOT IN (SELECT question_id FROM question_answers)");
                while ($row = mysqli_fetch_assoc($runSql)) {
                  echo '<option value="'.$row['id'].'">'.$row['id']. ' - '.$row['sheet'].' - '.$row['question'].'</option>';
                }
                ?>
              </select>
            </div>
            <hr>
            <div class="mb-3">
              <label class="form-label">A</label>
              <input type="text" name="a" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">B</label>
              <input type="text" name="b" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">C</label>
              <input type="text" name="c" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">D</label>
              <input type="text" name="d" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>

      <!-- Option 1: Bootstrap Bundle with Popper -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
    </html>