<?php
  $color = "green";
  $header_size = 1;
  $header_class = "";
  $col_tag_begin = '<div class="col s12 $color-text text-lighten-1">';
  $col_tag_end = "</div>";

  switch ($page)
  {
    case 'about':
      $title_content = "About Me";
      $header_size = 2;
      $col_tag_begin = $col_tag_end = "";
      $header_class = " class=\"header $color-text text-darken-1\"";
      break;
    case 'assign':
      $title_content = "Page Coming Soon!";
      $color = "blue";
      break;
    default:
      $title_content = "Web Engineering II";
      break;
  }
  echo strtr(
    "$col_tag_begin
    <h$header_size$header_class>$title_content</h$header_size>
  $col_tag_end\n", array('$color' => $color));
 ?>
