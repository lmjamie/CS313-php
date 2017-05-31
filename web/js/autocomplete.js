//This came mostly from stackoverflow https://stackoverflow.com/questions/1787322/htmlspecialchars-equivalent-in-javascript
function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
    '/': '&#x2F;',
    '`': '&#x60;',
    '=': '&#x3D;'
  };

  return text.replace(/[&<>"'`=\/]/g, function(m) { return map[m]; });
}

function remove_nonnumbers(element, value) {
  $(element).val(value.replace(/\D/g, ''));
}

function populate_versions(card_name) {
  if (card_name.length) {
    $('#ac').empty();
    $.ajax({
        type: "POST",
        url: "php/get_versions.php",
        data: { name: card_name },
        success: function(data) {
          data = JSON.parse(data);
          if (!$.isEmptyObject(data)) {
            $('#card_details').removeClass('hide');
            $('#error_text').html("");
            var ver_select = $('#version');
            ver_select.empty();
            for (var num in data) {
              var version = data[num];
              ver_select.append(
                "<option value=\"" + version.id + "\"  data-icon=\"" + version.image +
                "\" class=\"left\">" + version.set + " (#" + version.num + ")</option>"
              );
            }
            $('#selected-image').attr("src", data[0].image);
            ver_select.on("change", function() {
              selected_option = $("option[value='" + this.value + "']", this);
              $('#selected-image').attr("src", selected_option.attr("data-icon"));
            }).material_select();
            $('#add_button').removeClass('disabled');
          } else {
            var add_button = $('#add_button');
            if (!add_button.hasClass('disabled')) {
              add_button.addClass('disabled');
            }
            var card_details = $('#card_details');
            if (!card_details.hasClass('hide')) {
              card_details.addClass('hide');
            }
            $('#no_match').removeClass('hide');
            $('#error_text').html("No Cards named \"" + escapeHtml(card_name) + "\" found.<br>Try typing and select one of the suggestions!");
          }
        }
        // make ajax request to database through php. Get all specific cards with this name.
        //If none, then put no matches error and suggestion to start typing.
      });
    }
  }

  function autocomplete_populate(clicked) {
    var card_name = $(clicked.currentTarget).text().trim();
    $('#card_name').val(escapeHtml(card_name));
    populate_versions(card_name);
  }

  // A lot of this code has been modified from a stackoverflow post found here https://goo.gl/pt8LfP
  // Most of what is there is just modified materialize code.
  function ajaxAutoComplete(options) {

    var defaults = {
      inputId: null,
      ajaxUrl: false,
      limit: 9,
      data: {},
      minLength: 1
    };

    options = $.extend(defaults, options);
    var $input = $("#" + options.inputId);


    if (options.ajaxUrl) {


      var $autocomplete = $('<ul id="ac" class="autocomplete-content dropdown-content"' +
          'style="position:absolute"></ul>'),
        $inputDiv = $input.closest('.input-field'),
        request,
        runningRequest = false,
        timeout,
        liSelected;

      if ($inputDiv.length) {
        $inputDiv.append($autocomplete); // Set ul in body
      } else {
        $input.after($autocomplete);
      }

      var highlight = function(string, match) {
        var matchStart = string.toLowerCase().indexOf("" + match.toLowerCase() + ""),
          matchEnd = matchStart + match.length - 1,
          beforeMatch = string.slice(0, matchStart),
          matchText = string.slice(matchStart, matchEnd + 1),
          afterMatch = string.slice(matchEnd + 1);
        string = "<span>" + beforeMatch + "<span class='highlight'>" +
          matchText + "</span>" + afterMatch + "</span>";
        return string;

      };

      $autocomplete.on('click', 'li', autocomplete_populate);

      $input.on('keyup', function(e) {

        if (timeout) { // comment to remove timeout
          clearTimeout(timeout);
        }

        if (runningRequest) {
          request.abort();
        }

        if (e.which === 13) { // select element with enter key
          if (liSelected) {
            liSelected[0].click();
          } else {
            $('#search').click();
          }
          return;
        }

        // scroll ul with arrow keys
        if (e.which === 40) { // down arrow
          if (liSelected) {
            liSelected.removeClass('selected');
            next = liSelected.next();
            if (next.length > 0) {
              liSelected = next.addClass('selected');
            } else {
              liSelected = $autocomplete.find('li').eq(0).addClass('selected');
            }
          } else {
            liSelected = $autocomplete.find('li').eq(0).addClass('selected');
          }
          return; // stop new AJAX call
        } else if (e.which === 38) { // up arrow
          if (liSelected) {
            liSelected.removeClass('selected');
            next = liSelected.prev();
            if (next.length > 0) {
              liSelected = next.addClass('selected');
            } else {
              liSelected = $autocomplete.find('li').last().addClass('selected');
            }
          } else {
            liSelected = $autocomplete.find('li').last().addClass('selected');
          }
          return;
        }

        // escape these keys
        if (e.which === 9 || // tab
          e.which === 16 || // shift
          e.which === 17 || // ctrl
          e.which === 18 || // alt
          e.which === 20 || // caps lock
          e.which === 35 || // end
          e.which === 36 || // home
          e.which === 37 || // left arrow
          e.which === 39) { // right arrow
          return;
        } else if (e.which === 27) { // Esc. Close ul
          $autocomplete.empty();
          return;
        }
        //reset count
        count = 0;

        var val = $input.val().toLowerCase();
        $autocomplete.empty();

        if (val.length > options.minLength) {

          timeout = setTimeout(function() { // comment this line to remove timeout
            runningRequest = true;

            request = $.ajax({
              type: 'GET',
              url: options.ajaxUrl,
              data: {
                search: val
              },
              success: function(data) {
                if (!$.isEmptyObject(data)) { // (or other) check for empty result
                  var appendList = '';
                  for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                      if (count >= options.limit) {
                        break;
                      }
                      var li = '';
                      if (!!data[key]) { // if image exists as in official docs
                        li += '<li><img src="' + data[key] + '" class="left">';
                        li += "<span>" + highlight(key, val) + "</span></li>";
                      } else {
                        li += '<li><span>' + highlight(key, val) + '</span></li>';
                      }
                      appendList += li;
                      count++;
                    }
                  }
                  $autocomplete.append(appendList);
                } else {
                  $autocomplete.append($('<li><span>No Matches</span></li>'));
                }
              },
              complete: function() {
                runningRequest = false;
              }
            });
          }, 250); // comment this line to remove timeout
        }
      });

      $(document).click(function() { // close ul if clicked outside
        if (!$(event.target).closest($autocomplete).length) {
          $autocomplete.empty();
        }
      });
    }
  }
