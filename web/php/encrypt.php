<?php
  function cams_encrypt($unhash, $rounds = 10) {
    return password_hash($unhash, PASSWORD_BCRYPT, array("cost" => $rounds));
  }
?>
