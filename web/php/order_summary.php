
<h5 class="green-text">Your Order:</h5>
<p class="flow-text blue-grey-text text-darken-1 left-align">
<?php
echo "For $" . number_format($_SESSION["total"], 2) . "<br>";
$first = true;
foreach ($_SESSION["cart_items"] as $name => $sell_qty) {
  echo (!$first ? ", " : "") . "$sell_qty x $name";
  $first = false;
  $_SESSION["items_for_sale"][$name]->sell($sell_qty);
}
unset($_SESSION["cart_items"]);
?>
</p>
<h5 class="green-text">Will be shipped to:</h5>
<p class="flow-text blue-grey-text text-darken-1 left-align">
<?php
  $fn = $_POST["fn"];
  $ln = $_POST["ln"];
  $add = $_POST["add"];
  $add2 = $_POST["add2"];
  $city = $_POST["city"];
  $state = strtoupper($_POST["state"]);
  $zip = $_POST["zip"];
  $email = $_POST["email"];
  echo "$fn $ln:<br>" . ($email ? "$email<br>" : "") .
  "At the address:<br>
  $add<br>" . ($add2 ? "$add2<br>" : "") .
  "$city, $state $zip";
?>
</p>
<h5 class="green-text">Confirmation Number:</h5>
<p class="flow-text blue-grey-text text-darken-1 left-align">
<?php
  echo $fn[0], $add[0], $ln[0], " - " ,rand(10, 99), $city[0], rand(100, 999), $zip[0];
?>
</p>
