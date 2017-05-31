<?php
  require("php/moving_page.php");
  $needed = array("name", "set", "num");
  require("sql/midl.php");

  function check_card_name($card_name) {
    global $db;
    $stmt = $db->prepare("SELECT id FROM cards WHERE name = :card_name");
    $stmt->execute(array(':card_name' => $card_name));
    $id_check = $stmt->fetch();

    if (!$id_check) {
      move_if_not_set_in_session("Failure", "inventory.php", "Invalid Card Name");
    }
    return $id_check['id'];
  }

  function check_set($set_code) {
    global $db;
    $stmt = $db->prepare("SELECT id FROM sets WHERE code = :set_code");
    $stmt->execute(array(':set_code' => $set_code));
    $id_check = $stmt->fetch();
    if (!$id_check) {
      move_if_not_set_in_session("Failure", "inventory.php", "Invalid Set Code");
    }
    return $id_check['id'];
  }

  function check_specificcard($card_id, $set_id, $numinset) {
    global $db;
    $stmt = $db->prepare("SELECT id FROM specificcards WHERE cardid = :cardid
      AND setid = :setid AND numinset = :numinset");
    $stmt->execute(array(':cardid' => $card_id, ':setid' => $set_id, ':numinset' => $numinset));
    if (!$stmt->fetch()) {
      move_if_not_set_in_session("Failure", "inventory.php", "Card Not in Set");
    }
  }

  function check_get_details() {
    global $needed;
    foreach ($needed as $value) {
      move_if_not_set_in_get($value, "inventory.php", "Please Click <br> on a Card");
    }
    $card_id = check_card_name($_GET[$needed[0]]);
    $set_id = check_set($_GET[$needed[1]]);
    check_specificcard($card_id, $set_id, $_GET[$needed[2]]);
  }

  function grab_details($card_name, $set_code, $numinset) {
    global $db;
    $stmt = $db->prepare(
      "SELECT c.name, c.manacost AS mc, c.cmc, spt1.name AS spt1, spt2.name AS spt2,
        t1.name AS t1, t2.name AS t2, sbt1.name AS sub1, sbt2.name AS sub2,
        sbt3.name AS sub3, sbt4.name AS sub4, c.rules, sc.flavor AS f, c.power AS p,
        c.toughness AS t, c.loyalty AS l, s.name AS set, r.type AS r, sc.imageurl AS iu
      FROM cards c
      JOIN specificcards sc ON c.id = sc.cardid
      LEFT JOIN supertypes spt1 ON spt1.id = c.supertypeid1
      LEFT JOIN supertypes spt2 ON spt2.id = c.supertypeid2
      JOIN types t1 ON t1.id = c.typeid1
      LEFT JOIN types t2 ON t2.id = c.typeid2
      LEFT JOIN subtypes sbt1 ON sbt1.id = c.subtypeid1
      LEFT JOIN subtypes sbt2 ON sbt2.id = c.subtypeid2
      LEFT JOIN subtypes sbt3 ON sbt3.id = c.subtypeid3
      LEFT JOIN subtypes sbt4 ON sbt4.id = c.subtypeid4
      JOIN sets s ON s.id = sc.setid
      JOIN rarities r ON r.id = sc.rarityid
      WHERE c.name = :card_name AND s.code = :set_code AND sc.numinset = :numinset"
    );
    $stmt->execute(array(':card_name' => $card_name, ':set_code' => $set_code, ':numinset' => $numinset));
    return $stmt->fetch();
  }

  check_get_details();
  $_SESSION['card'] = grab_details($_GET[$needed[0]], $_GET[$needed[1]], $_GET[$needed[2]]);
 ?>
