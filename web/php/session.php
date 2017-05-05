<?php
  session_start();
  $now = time();
  if (isset($_SESSION["Restart"]) and $now >= $_SESSION["Restart"]) {
    // Destroy them, they are out of bounds.
    session_unset();
    session_destroy();
    session_start();
  }

//living a minute at a time.
  $_SESSION["Restart"] = $now + 3600;
?>
