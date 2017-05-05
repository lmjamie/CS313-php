<?php
  require("php/item_class.php");
  require("php/session.php");
  if (!isset($_SESSION["cart_items"])) {
    header("Location: cart.php");
    die();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Checkout</title>
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
        <form action="confirm.php" method="post" class="col m12 l8 offset-l2">
          <div class="row">
            <div class="input-field col s6">
              <input type="text" id="first_name" name="fn" class="validate" required>
              <label for="first_name">First Name*</label>
            </div>
            <div class="input-field col s6">
              <input type="text" id="last_name" name="ln" class="validate" required>
              <label for="last_name">Last Name*</label>
            </div>
            <div class="input-field col s6">
              <input type="text" id="address" name="add" class="validate" required>
              <label for="address">Address*</label>
            </div>
            <div class="input-field col s6">
              <input type="text" id="address2" name="add2" class="validate">
              <label for="address2">Address 2</label>
            </div>
            <div class="input-field col s6">
              <input type="text" id="city" name="city" class="validate" required>
              <label for="city">City*</label>
            </div>
            <div class="input-field col s2">
              <input type="text" id="state" name="state" class="validate" maxlength="2" required>
              <label for="state">State*</label>
            </div>
            <div class="input-field col s4">
              <input type="text" id="zip" name="zip" class="validate" maxlength="5" required>
              <label for="zip">Zipcode*</label>
            </div>
            <div class="input-field col s12">
              <input type="email" id="email" name="email" class="validate">
              <label for="email" data-error="invalid email">E-mail</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s4">
              <button type="submit" class="btn waves-effects waves green darken-1 green-text text-lighten-4">
                Confirm<i class="material-icons right">done</i>
              </button>
            </div>
            <div class="input-field col s4 offset-s4">
            <a href="cart.php" class="btn waves-effects red blue-grey-text text-lighten-5">
              Cancel<i class="material-icons right">cancel</i>
            </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>
  <footer class="page-footer green lighten-1">
    <?php require("php/footer.php"); ?>
  </footer>
</body>

</html>
