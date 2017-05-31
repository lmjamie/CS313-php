<?php
  require("moving_page.php");
  move_if_not_set_in_post("name", "../inventory.php", "No Post Data", true);
  require("../sql/midl.php");
  function versions($name) {
    global $db;
    $prep = $db->prepare(
      "SELECT sc.id, s.code AS set, sc.numinset AS num, sc.imageurl AS image FROM specificcards sc
      JOIN sets s ON s.id = sc.setid
      JOIN cards c ON c.id = sc.cardid
      WHERE LOWER(c.name) = LOWER(:name)
      ORDER BY s.code,
      sc.numinset"
    );
    $prep->execute(array(':name' => $name));
    $results = array();
    $all_rows = $prep->fetchAll();
    if ($all_rows) {
      $results = $all_rows;
    }
     return json_encode($results);
  }

  echo versions($_POST['name']);

?>
