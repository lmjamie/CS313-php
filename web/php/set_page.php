<?php
  session_start();
  $item_name = $_POST["item"];

  $_SESSION["detail_item"] = $_SESSION["items_for_sale"][$item_name];
?>
