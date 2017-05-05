<div class="col l6 offset-l3 m12">
<?php
if (isset($_SESSION["cart_items"]))  {
    $_SESSION['total'] = 0.0;
    $_SESSION['count'] = 0;
    echo "<a id=\"empty_cart\" href=\"#\" value=\"all\" onclick=\"edit_cart($('#empty_cart'))\" class=\"waves-effect btn red blue-grey-text text-lighten-5\">
    <i class=\"material-icons right\">remove_circle</i>Empty Cart</a>
    <ul class=\"collection\">";
    $i = 0;
    foreach ($_SESSION["cart_items"] as $name => $sell_qty) {
      $_SESSION['total'] += $_SESSION['items_for_sale'][$name]->calc_discount($sell_qty);
      $_SESSION['count'] += $sell_qty;
      echo "<li class=\"collection-item avatar blue-grey darken-2 green-text text-lighten-5\">";
      $_SESSION['items_for_sale'][$name]->cart_display($sell_qty, $i);
      echo "</li>";
      ++$i;
    }
    echo "</ul>
    <div class=\"card green-text text-lighten-5\">
    <div class=\"card-panel blue-grey darken-2\">
    <span>Order Count: " . $_SESSION['count'] . "</span><br>
    <span>Cart Total: $" . number_format($_SESSION['total'], 2) . "</span>
    <a href=\"checkout.php\" class=\"waves-effect waves-purple btn green blue-grey-text text-lighten-5 right\">
    <i class=\"material-icons right\">send</i>Checkout</a>
    </div></div>";
}
else {
  echo "<div class=\"card green-text text-lighten-5\">
  <div class=\"card-panel blue-grey darken-2\">
  <p class=\"flow-text\">Oops! <br>Your shopping cart is empty! Why not go to Browse Store and add something to it?</p>
  </div>
  </div>";
}
?>

</div>
