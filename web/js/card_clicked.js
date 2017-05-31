function card_details(element) {
  var clicked = $(element);
  var set_of_clicked = clicked.attr("value"),
      name_of_clicked = clicked.html(),
      num_of_clicked = clicked.attr("data-num");
  var hidden_form =  $("<form class=\"hide\" action=\"card_details.php\" method=\"GET\">" +
    "<input type=\"text\" name=\"name\" value=\"" + name_of_clicked + "\">" +
    "<input type=\"text\" name=\"set\" value=\"" + set_of_clicked + "\"/>" +
    "<input type=\"text\" name=\"num\" value=\"" + num_of_clicked + "\"/>" +
    "</form>");
    $("body").append(hidden_form);
    hidden_form.submit();
}
