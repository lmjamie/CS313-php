<?php
  require("php/item_class.php");
  require("php/session.php");
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landon's Store</title>
    <link rel="stylesheet" href="css/sticky_footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/set_page.js"></script>
  </head>

  <body class="blue-grey lighten-5">
    <header>
      <?php require("php/store_nav.php"); ?>
    </header>
    <main>
      <div class="container center">
        <div class="row">
          <?php require("php/titles.php"); ?>
        </div>
        <div class="row">
          <?php
           require("php/store_items.php");
           display_items();
           ?>
        </div>
      </div>
    </main>
    <footer class="page-footer green lighten-1">
      <?php require("php/footer.php"); ?>
    </footer>
  </body>

  </html>
