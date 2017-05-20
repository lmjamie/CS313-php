<?php
  require("moving_page.php");
  unset($_SESSION["username"], $_SESSION["fname"], $_SESSION["lname"]);
  move_if_not_set_in_session("username", "../login.php",
                             "Succesfully Logged Out");
?>
