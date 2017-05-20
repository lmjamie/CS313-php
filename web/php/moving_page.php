<?php
  session_start();
  function move_if_not_set_in_session($check, $to, $error = "Not set in session") {
    if (!isset($_SESSION[$check])) {
      $_SESSION["Failure"] = $error;
      header("Location: $to");
      die();
    }
  }
  function move_if_set_in_session($check, $to) {
    if (isset($_SESSION[$check])) {
      header("Location: $to");
      die();
    }
  }
  function move_if_not_set_in_post($check, $to, $error = "not set by post")
  {
    if (!isset($_POST[$check])) {
      $_SESSION["Failure"] = $error;
      header("Location: $to");
      die();
    }
  }
?>
