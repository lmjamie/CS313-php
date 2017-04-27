<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Landon Jamieson's Homepage</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
  <script src="js/navbar.js"></script>
</head>

<body>
  <header>
    <?php require('php/navbar.php'); ?>
  </header>
  <main>
    <div class="container center">
      <div class="row">
        <?php require('php/titles.php'); ?>
      </div>
      <div class="row">
        <div class="col m12 l5 offset-l1">
          <?php
           require("php/subject_card.php");
           make_card(0);
           ?>
        </div>
        <div class="col m12 l5">
          <?php make_card(1); ?>
        </div>
      </div>
    </div>
  </main>
  <footer class="page-footer green lighten-1">
    <?php require("php/footer.php"); ?>
  </footer>
</body>

</html>
