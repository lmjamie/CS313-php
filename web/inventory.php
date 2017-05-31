<?php
  require("php/moving_page.php");
  move_if_not_set_in_session("username", "login.php", "Please Login");
  require_once("sql/midl.php");
  require('php/inv_table.php');
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Magic Card Inventory</title>
  <link rel="stylesheet" href="css/sticky_footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="css/table_colors.css">
  <link rel="stylesheet" href="css/autocomplete.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
  <script src="js/autocomplete.js"></script>
  <script src="js/inv_nav.js"></script>
  <script src="js/card_clicked.js"></script>
  <script src="js/add_to_functions.js"></script>
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
          success_check();
          failure_check();
        ?>
        <div id="totals_counts" class="col s12 blue-grey-text text-lighten-1">
          <?php inventory_count_display(); ?>
        </div>
      </div>
      <div id="table_div" class="row">
        <?php print_table(); ?>
      </div>
    </div>
    <?php require("php/add_card_button.php"); ?>
  </div>
  </main>
  <footer class="page-footer green lighten-1">
    <?php require("php/footer.php"); ?>
  </footer>
</body>

</html>
