<?php
  require("moving_page.php");
  require("encrypt.php");
  $needed = array("un", "pw", "pwc", "fn", "ln");

  function check_post_account() {
    global $needed;
    foreach ($needed as $value) {
      move_if_not_set_in_post($value, "../create_account.php", "Please Create <br> An Account");
    }
  }
  require("../sql/midl.php");

  function pass_match($pw, $pwc) {
    return $pw === $pwc;
  }

  function check_collector($un) {
    global $db;
    $stmt = $db->prepare("SELECT username FROM collectors WHERE username = :un");
    $stmt->execute(array(':un' => $un));
    if ($stmt->fetch()) {
      move_if_not_set_in_session("username", "../create_account.php", "Username Taken");
    }
  }

  function new_collector($un, $phash, $fn, $ln) {
    global $db;
    $stmt = $db->prepare("INSERT INTO collectors(username, password, fname, lname)
    VALUES (:un, :phash, :fn, :ln)");
    $stmt->execute(array(':un' => $un, ':phash' => $phash, ':fn' => $fn, ':ln' => $ln));
  }

  function new_inventory($col_id) {
    global $db;
    $stmt = $db->prepare("INSERT INTO inventories(totalcards, distinctcards, collectorid)
    VALUES (0, 0, :colid)");
    $stmt->execute(array(':colid' => $col_id));
  }

  function new_tradelist($inv_id) {
    global $db;
    $stmt = $db->prepare("INSERT INTO tradelists(totaltrade, distincttrade, inventoryid)
    VALUES (0, 0, :invid)");
    $stmt->execute(array(':invid' => $inv_id));
  }

  function new_wantlist($col_id) {
    global $db;
    $stmt = $db->prepare("INSERT INTO wantlists(totalwanted, distinctwanted, collectorid)
    VALUES (0, 0, :colid)");
    $stmt->execute(array(':colid' => $col_id));
  }

  function create_account($un, $phash, $fn, $ln) {
    global $db;
    new_collector($un, $phash, $fn, $ln);
    $col_id = $db->lastInsertId();
    new_inventory($col_id);
    $inv_id = $db->lastInsertId();
    new_tradelist($inv_id);
    new_wantlist($col_id);
    return $col_id;
  }
  check_post_account();
  $pw = $_POST[$needed[1]];
  $pwc = $_POST[$needed[2]];

  if (pass_match($pw, $pwc)) {
    $un = clean_HTML_POST($needed[0]);
    check_collector($un);
    $fn = clean_HTML_POST($needed[3]);
    $ln = clean_HTML_POST($needed[4]);
    $phash = cams_encrypt($pw);
    $col_id = create_account($un, $phash, $fn, $ln);

    $_SESSION["username"] = $un;
    $_SESSION["fname"] = $fn;
    $_SESSION["lname"] = $ln;
    $_SESSION["collector_id"] = $col_id;

    move_if_set_in_session("username", "../inventory.php", "Account Created!");
  } else {
    move_if_not_set_in_session("username", "../create_account.php", "Passwords Do Not Match");
  }

?>
