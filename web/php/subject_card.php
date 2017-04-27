<?php
$image_alts = array("Sadie and I" , "Assignments");
$image_paths = array("images/sadieandi.jpg", "images/magic-hand.jpg");
$titles = array("About Me", "Assignments");
$colors = array("green" , "blue");
$descriptions = array("I am Landon Jamieson! You can learn a little bit more about me by following the link on this card.", "Click the link below to view my assignments for this class.");
$links = array("about" , "assign");
$action_name = array("Learn More", "My Assignments");

function make_card($card_num) {
  global $images_alts, $image_paths, $titles, $colors, $descriptions, $links, $action_name;
  echo
  "<div class=\"card z-depth-5\">
    <div class=\"card-image\">
      <img alt=\"" . $image_alts[$card_num] . "\" src=\"" . $image_paths[$card_num] . "\">
      <span class=\"card-title\">" . $titles[$card_num] . "</span>
    </div>
    <div class=\"card-content " . $colors[$card_num] . " lighten-5\">
      <p>
        " . $descriptions[$card_num] . "
      </p>
    </div>
    <div class=\"card-action " . $colors[$card_num] . " lighten-5\">
      <a href=\"" . $links[$card_num] . ".php\">" . $action_name[$card_num] . "</a>
    </div>
  </div>\n";
}
 ?>
