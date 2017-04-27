<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <title>About Me - Landon Jamieson</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
        <script src="js/aboutjs.js"></script>
    </head>
    <body>
        <header>
          <?php require('php/navbar.php'); ?>
        </header>
        <main>
            <?php
            require("php/parallax_image.php");
            parallax_image("images/sadieandi.jpg", "Sadie and I");
             ?>
            <div class="section green lighten-5">
                <div class="row container">
                    <?php require('php/titles.php'); ?>
                     <div class="divider black"></div>
                     <?php require('php/info.php') ?>
                </div>
            </div>
            <?php parallax_image("images/wedding_posed.jpg", "Posed Wedding Photo"); ?>
        </main>
        <footer class="page-footer green lighten-1">
            <?php require("php/footer.php"); ?>
        </footer>
    </body>
</html>
