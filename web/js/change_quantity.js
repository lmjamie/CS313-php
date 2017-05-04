function update_quantity(new_qty) {
  var el = $('.dropdown-button');
  el.html("<i class=\"material-icons left\">expand_more</i>" + new_qty);
  el.attr("value", new_qty);
}
