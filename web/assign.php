<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Assignments - Web II</title>
  <link rel="stylesheet" href="css/sticky_footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
        <?php
         require('php/image.php');
        make_image("images/fast-keyboard.gif", "Fast Typing", 3);
        require("php/stalling_quote.php");
        make_image("images/fist-keyboard.gif", "Fist Typing", 3);
        ?>
      </div>
      <div class="row">
        <div class="col s12">
          <ul class="collection">
            <li class="collection-item blue lighten-2 flow-text"><a class="blue-text text-lighten-5" href="homepage.php">Homepage</a></li>
            <li class="collection-item blue lighten-2 flow-text"><a class="blue-text text-lighten-5" href="store.php">Store</a></li>
          </ul>
        </div>
      </div>
    </div>
  </main>
  <footer class="page-footer green lighten-1 bottom">
    <?php require('php/footer.php') ?>
  </footer>
</body>

</html>
