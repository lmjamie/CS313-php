<?php
  require("moving_page.php");
  unset($_SESSION["username"], $_SESSION["fname"], $_SESSION["lname"], $_SESSION["collector_id"],
        $_SESSION["inventory"], $_SESSION["tradelist"], $_SESSION["wantlist"]);
  move_if_not_set_in_session("username", "../login.php",
                             "Succesfully <br> Logged Out");?>
$_SESSION['wantlist']
