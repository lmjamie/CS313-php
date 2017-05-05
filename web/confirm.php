<?php
  require("php/item_class.php");
  require("php/session.php");
  if (!isset($_POST["fn"])) {
    header("Location: checkout.php");
    die();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Order Confirmation</title>
  <link rel="stylesheet" href="css/sticky_footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
  <script src="js/navbar.js"></script>
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
        <div class="col l10 offset-l1 m12">
          <?php require("php/order_summary.php"); ?>
          <a href="store.php" class="btn waves-effect waves-purple green lighten-1 green-text text-lighten-5">
            Back to Store<i class="material-icons right">store</i>
          </a>
        </div>
      </div>
    </div>
  </main>
  <footer class="page-footer green lighten-1">
    <?php require("php/footer.php"); ?>
  </footer>
</body>

</html>
