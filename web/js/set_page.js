function set_page(element) {
  var item_name = element.value;
  $.ajax({
    method: "POST",
    url: "php/set_page.php",
    data: { item: item_name }
  })
    .done(function (response, textStatus, jqXHR) {
      window.location.href = "item_detail.php";
  });
}
