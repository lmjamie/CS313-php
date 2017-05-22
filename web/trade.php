<?php
  require("php/moving_page.php");
  move_if_not_set_in_session("username", "login.php", "Please Login");
  require("sql/midl.php");
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Magic Card Tradelist</title>
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
        <?php require("php/titles.php"); ?>
        <div class="col s12 blue-grey-text text-lighten-1">
          <?php
            $stmt = $db->prepare("SELECT tl.totaltrade, tl.distincttrade
              FROM tradelists AS tl, inventories AS i
              WHERE i.collectorid = :cid AND tl.inventoryid = i.id");
            $stmt->execute(array(':cid' => $_SESSION["collector_id"]));
            $trade_totals = $stmt->fetch();
            echo "<h6>Total Trades: " . $trade_totals[0] ." -- Distinct Trades: " . $trade_totals[1] . "</h6>";
          ?>
        </div>
      </div>
      <div class="row">
        <?php require("php/trade_table.php"); ?>
      </div>
    </div>
  </main>
  <footer class="page-footer green lighten-1">
    <?php require("php/footer.php"); ?>
  </footer>
</body>

</html>
