$(document).ready(function(){
    $(".button-collapse").sideNav({
        edge: 'right'
    });
    $('select').each(function() {
      $(this).material_select()
    });
    Materialize.showStaggeredList('.collection')

});
