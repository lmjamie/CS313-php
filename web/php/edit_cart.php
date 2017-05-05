<?php
  session_start();
  $edit = $_POST['edit'];
  if ("all" == $edit) {
    unset($_SESSION['cart_items']);
  }
  else {
    $qty = $_POST['qty'];
    if ($qty == 0) {
      unset($_SESSION["cart_items"][$edit]);
    }
    else {
      $_SESSION["cart_items"][$edit] = $qty;
    }
    if (empty($_SESSION["cart_items"])) {
      unset($_SESSION["cart_items"]);
    }
  }
?>
