$(document).ready(function(){
    $(".button-collapse").sideNav({
        edge: 'right'
    });
    $('.modal').modal({
      complete: function() {
        var $card_details = $('#card_details'),
            $match_error = $('#no_match'),
            $add_button = $('#add_button');
        $('#version').empty();
        $('[id$=_qty]').val("1");
        if (!$card_details.hasClass('hide')) {
          $card_details.addClass('hide');
        }
        if (!$match_error.hasClass('hide')) {
          $match_error.addClass('hide');
        }
        if (!$add_button.hasClass('disabled')) {
          $add_button.addClass('disabled');
        }
      }
    });
    $('select').material_select();
    ajaxAutoComplete({inputId:'card_name',ajaxUrl:'php/autocomplete.php'});
});
