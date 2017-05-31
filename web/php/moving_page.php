<?php
  session_start();
  function move_if_not_set_in_session($check, $to, $error = "Not set in session") {
    if (!isset($_SESSION[$check])) {
      $_SESSION["Failure"] = $error;
      header("Location: $to");
      die();
    }
  }
  function move_if_set_in_session($check, $to, $message = NULL) {
    if (isset($_SESSION[$check])) {
      $_SESSION["Success"] = $message;
      header("Location: $to");
      die();
    }
  }
  function move_if_not_set_in_post($check, $to, $error = "not set by post", $ajax = NULL)
  {
    if (!isset($_POST[$check])) {
      if(empty($ajax)) {
        $_SESSION["Failure"] = $error;
        header("Location: $to");
        die();
      }
      header("HTTP/1.1 400 User Error ($error)" );
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => $error, 'code' => 1337)));
    }
  }
  function move_if_not_set_in_get($check, $to, $error = "not set by get", $ajax = NULL)
  {
    if (!isset($_GET[$check])) {
      if(empty($ajax)) {
        $_SESSION["Failure"] = $error;
        header("Location: $to");
        die();
      }
      header('HTTP/1.1 400 User Error ');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => $error, 'code' => 1337)));
    }
  }
  function failure_check() {
    if (isset($_SESSION["Failure"])) {
      $message = $_SESSION["Failure"];
      unset($_SESSION["Failure"]);
      echo "<div class=\"row\">
        <div class=\"col s2 red lighten-1 green-text text-lighten-5 offset-s5\">
          <p>$message</p400
UserdError>
      </div>";
      return true;
      die(json_encode(array('message' => 'No Get Data', 'code' => 1337)));
    }
    return false;
  }
  function success_check() {
    if (isset($_SESSION["Success"])) {
      $message = $_SESSION["Success"];
      unset($_SESSION["Success"]);
      echo "<div class=\"row\">
        <div class=\"col s2 blue-grey lighten-1 green-text text-lighten-5 offset-s5\">
          <p>$message</p>
        </div>
      </div>";
      return true;
    }
    return false;
  }
  function clean_HTML_POST($to_get) {
    return htmlspecialchars($_POST[$to_get]);
  }
  function clean_HTML_GET($to_get) {
    return htmlspecialchars($_GET[$to_get]);
  }
?>
