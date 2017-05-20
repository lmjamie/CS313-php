<?php
  require("moving_page.php");
  require("encrypt.php");
  $needed = array("un", "pw");

  function check_post_login() {
    global $needed;
    foreach ($needed as $value) {
      move_if_not_set_in_post($value, "../login.php", "Please Login");
    }
  }
  require("../sql/midl.php");

  function clean_HTML_POST($to_get) {
    return htmlspecialchars($_POST[$to_get]);
  }

  function grab_phash($username) {
    global $db;
    $stmt = $db->prepare("SELECT password FROM collectors WHERE username = :username");
    $stmt->execute(array(':username' => $username));
    return $stmt->fetchColumn();
  }

  function grab_name_of_user($username) {
    global $db;
    $stmt = $db->prepare("SELECT fname, lname FROM collectors WHERE username = :username");
    $stmt->execute(array(':username' => $username));
    return $stmt->fetch();
  }

  check_post_login();
  $un_in = clean_HTML_POST($needed[0]);
  $pw_in = $_POST[$needed[1]];
  $phashed = grab_phash($un_in);

  if (password_verify($pw_in, $phashed)) {
    $name = grab_name_of_user($un_in);
    $_SESSION["username"] = $un_in;
    $_SESSION["fname"] = $name[0];
    $_SESSION["lname"] = $name[1];
    move_if_set_in_session("username", "../inventory.php");
  } else {
    move_if_not_set_in_session("username", "../login.php", "Invalid Username or Password");
  }

?>
