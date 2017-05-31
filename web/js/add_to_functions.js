function adding_ajax(add_type) {
  var sc_id = $('#version').val(),
      the_qty = $('#' + add_type + '_qty').val().replace(/\D/g, ''),
      the_cond = $('#condition_select').val(),
      is_foil = $('#foil_select').val() === 'true';
  $(".modal").modal("close");
  if (the_qty > 0) {
    $.ajax({
      type: "POST",
      url: "php/add_to_database.php",
      data: {
        type: add_type,
        scid: sc_id,
        qty: the_qty,
        cond: the_cond,
        foil: is_foil
      },
      success: function(data) {
        var the_url = "";
        switch (add_type) {
          case 'inventory':
            the_url = "php/inv_table.php"
            break;
          case 'want':
            the_url = "php/want_table.php"
            break;
          case 'trade':
            the_url = "php/trade_table.php"
        }
        $.ajax({
          type: "POST",
          url: the_url,
          data: "update=yes",
          success: function(data) {
            if(typeof data !='object')
              data = JSON.parse(data);
            $("#totals_counts").html(data['totals']);
            $("#table_div").html(data['table']);
            $(".tooltipped").each(function() {
              $(this).tooltip();
            });
          }
        })
      }
    });
  }
}
