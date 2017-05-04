<?php
  $pass = $_POST["password"];
  if ($pass == "5678") {
    session_start();
    $_SESSION["username"] = $_POST["username"];
    header("location: home.php");
    die();
  }
  else {
    header("location: login.php");
    die();
  }
?>
