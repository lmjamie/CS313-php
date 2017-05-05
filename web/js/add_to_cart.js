function add_to_cart(element) {
  var qty = $(".dropdown-button").attr("value"),
      max = $("dropdown-content").attr("value"),
      name = element.value;
  $.ajax({
    method: "POST",
    url: "php/add_to_cart.php",
    data: { item_qty: qty, max_qty: max, item_name: name }
  })
  .done(function (response, textStatus, jqXHR) {
      var toast_message = "Item added to your cart!<br>Click again to go there"
      var el = $('button');
      el.html("<i class=\"material-icons right\">done</i>Added to Cart!");
      el.attr("onclick", "location.href='cart.php'");
      el.attr("data-tooltip", "Click to go to your cart");
      el.tooltip();
      Materialize.toast(toast_message, 2000, 'rounded');
  });
}
