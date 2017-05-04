<?php
  session_start();
  if (!isset($_SESSION["username"])) {
    header("location: login.php");
    die();
  }
  
  $user = htmlspecialchars($_SESSION["username"]);
  echo "<h2>Welcome $user!</h2>";
?>
