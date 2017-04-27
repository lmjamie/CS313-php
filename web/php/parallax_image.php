<?php
function parallax_image($path, $alt) {
  echo
  "<div class=\"parallax-container\">
      <div class=\"parallax\"><img alt=\"$alt\" src=\"$path\"/></div>
  </div>\n";
}
?>
