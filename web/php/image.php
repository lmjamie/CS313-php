<?php
function make_image($path, $alt = "An Image") {
   echo
   "<div class=\"col m12 l4\">
   <img class=\"responsive-img\" alt=\"$alt\" src=\"$path\"/>
 </div>\n";
 }
?>
