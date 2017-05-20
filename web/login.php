<?php
  require("php/moving_page.php");
  move_if_set_in_session("username", "inventory.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login!</title>
  <link rel="stylesheet" href="css/sticky_footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
  <script src="js/navbar.js"></script>
</head>

<body class="blue-grey lighten-5">
  <header>
    <?php require("php/inv_nav.php"); ?>
  </header>
  <main>
    <div class="container center">
      <div class="row">
        <?php
          require("php/titles.php");
          require("php/image.php");
          make_image("favicon.ico", "Icon", 2, 2, "offset-l5 offset-m5 offset-s5", "s2");
        ?>
      </div>
      <?php
        if (isset($_SESSION["Failure"])) {
          $message = $_SESSION["Failure"];
          $adjust = true;
          unset($_SESSION["Failure"]);
          echo "<div class=\"row\">
            <div class=\"col s2 red lighten-1 green-text text-lighten-5 offset-s5\">
              <p>$message</p>
            </div>
          </div>";
        }
      ?>
      <div class="row">
        <?php require("php/login_form.php"); ?>
      </div>
    </div>
  </main>
  <footer class="page-footer green lighten-1">
    <?php require("php/footer.php"); ?>
  </footer>
</body>

</html>
