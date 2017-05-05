function edit_cart(element, new_qty) {
   var to_edit = element.attr("value");
  $.ajax({
    method: "POST",
    url: "php/edit_cart.php",
    data: { edit: to_edit, qty: new_qty }
  })
  .done(function (response, textStatus, jqXHR) {
    location.href = "cart.php";
  });
}
