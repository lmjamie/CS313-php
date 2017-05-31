$(document).ready(function(){
    $(".button-collapse").sideNav({
        edge: 'right'
    });
    $("#passwordc").change(function() {
      confirm = $(this);
      if (confirm.val() != $("#password").val()) {
        confirm.each(function() {
          this.setCustomValidity("The passwords must match!");
        });
      } else {
        confirm.each(function() {
          this.setCustomValidity('');
        });
      }
  });
});
