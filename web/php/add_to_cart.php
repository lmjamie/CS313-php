<?php
  session_start();
  $item_name = $_POST["item_name"];
  $item_qty = $_POST["item_qty"];
  $max_qty = $_POST["max_qty"];

  $_SESSION["cart_items"][$item_name] = (!isset($_SESSION["cart_items"][$item_name]) ? $item_qty : min($item_qty + $_SESSION["cart_items"][$item_name], $max_qty));
?>
