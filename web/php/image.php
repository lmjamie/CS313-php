<?php
function make_image($path, $alt = "An Image", $large_size = 4, $med_size = 12, $offset = "") {
   echo
   "<div class=\"col m$med_size l$large_size $offset\">
   <img class=\"responsive-img\" alt=\"$alt\" src=\"$path\"/>
 </div>\n";
 }
?>
