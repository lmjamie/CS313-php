<?php
  require("php/item_class.php");
  require("php/session.php");
  if (!isset($_SESSION["detail_item"])) {
    header("Location: store.php");
    die();
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Item Description</title>
    <link rel="stylesheet" href="css/sticky_footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/change_quantity.js"></script>
    <script src="js/add_to_cart.js"></script>
  </head>

  <body class="blue-grey lighten-5">
    <header>
      <?php require("php/store_nav.php"); ?>
    </header>
    <main>
      <?php $_SESSION['detail_item']->detail_display(); ?>
    </main>
    <footer class="page-footer green lighten-1">
      <?php require("php/footer.php"); ?>
    </footer>
  </body>

  </html>
