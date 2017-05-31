<?php
  require("moving_page.php");
  move_if_not_set_in_get("search", "../inventory.php", "Nothing to Search");
  require('../sql/midl.php');

  $search = '%' . $_GET['search'] . '%';
  if (!isset($_SESSION['autocomplete'])) {
    $_SESSION['autocomplete'] = $db->prepare("SELECT name FROM cards WHERE LOWER(name) LIKE LOWER(:search)");
  }
  $prep = $_SESSION['autocomplete'];
  $prep->execute(array(':search' => $search));
  $rows = $prep->fetchAll();
  foreach ($rows as $card) {
    $results[$card['name']] = NULL;
  }
  header('Content-Type: application/json');
  echo json_encode($results);
?>
