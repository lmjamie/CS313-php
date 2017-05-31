<div class="col l3 m12 s12">
  <img src=<?php echo "\"" . $_SESSION['card']['iu'] . "\""; ?> alt="Card Image">
</div>
<div class="col l8 m12 s12 right blue-grey darken-2 green-text text-lighten-5">
  <table>
    <tr>
      <?php
      function get_type_line($spt1, $spt2, $t1, $t2, $sbt1, $sbt2, $sbt3, $sbt4) {
        return (!empty($spt1) ? $spt1 . " " : "") . (!empty($spt2) ? $spt2 . " " : "") .
               $t1 . (!empty($t2) ? " " . $t2 : "") . (!empty($sbt1) ? " — " . $sbt1 : "") .
               (!empty($sbt2) ?  " " . $sbt2 : "") . (!empty($sbt3) ?  " " . $sbt3 : "") .
               (!empty($sbt4) ?  " " . $sbt4 : "");
      }

      function symbol_to_image($key, $size = 'small') {
        switch ($key) {
          case 'S':
            $name = 'snow';
            break;
          case 'T':
            $name = 'tap';
            break;
          case 'Q':
            $name = 'untap';
            break;
          default:
            $name = $key;
            break;
        }
        return "<img src='http://gatherer.wizards.com/Handlers/Image.ashx?size=$size&name=$name&type=symbol' alt='$key'/>";
      }

      function convert_symbols($symbols) {
        $symbol_images = "";
        preg_match_all('/\{([^}]+)\}/', $symbols, $keys);
        foreach ($keys[1] as $key) {
          $symbols_images .= symbol_to_image($key);
        }
        return $symbols_images;
      }

      function rules_symbols($rules) {
        return preg_replace_callback(
          '/\{([^}]+)\}/',
          function($match) { return symbol_to_image($match[1]); },
          $_SESSION['card']['rules']
        );
      }

      echo
      "<th class=\"right\">Card Name:</th>
      <td>" . $_SESSION['card']['name'] . "</td>
    </tr>
    <tr>
      <th class=\"right\">Mana Cost:</th>
      <td>" . convert_symbols($_SESSION['card']['mc']) . "</td>
    </tr>
    <tr>
      <th class=\"right\">Converted Mana Cost:</th>
      <td>" . $_SESSION['card']['cmc'] . "</td>
    </tr>
    <tr>
      <th class=\"right\">Types:</th>
      <td>" . get_type_line($_SESSION['card']['spt1'], $_SESSION['card']['spt2'],
       $_SESSION['card']['t1'], $_SESSION['card']['t2'], $_SESSION['card']['sub1'],
       $_SESSION['card']['sub2'], $_SESSION['card']['sub3'], $_SESSION['card']['sub4']) . "</td>
    </tr>";

    if (!empty($_SESSION['card']['rules'])) {
      echo
      "<tr>
        <th class=\"right\">Oracle Text:</th>
        <td><p style=\"white-space: pre-wrap;\">" . rules_symbols($_SESSION['card']['rules']) . "</p></td>
      </tr>";
    }

    if (!empty($_SESSION['card']['f'])) {
      echo
      "<tr>
        <th class=\"right\">Flavor Text:</th>
        <td><p style=\"white-space: pre-wrap;\">" . $_SESSION['card']['f'] . "</p></td>
      </tr>";
    }

    if (!empty($_SESSION['card']['p'])) {
      echo
      "<tr>
        <th class=\"right\">P / T:</th>
        <td>" . $_SESSION['card']['p'] . "/" . $_SESSION['card']['t'] . "</td>
      </tr>";
    }

    if (!empty($_SESSION['card']['l'])) {
      echo
      "<tr>
        <th class=\"right\">Loyalty:</th>
        <td>" . $_SESSION['card']['l'] . "</td>
      </tr>";
    }

    echo
    "<tr>
      <th class=\"right\">Expansion:</th>
      <td>" . $_SESSION['card']['set'] . "</td>
    </tr>
    <tr>
      <th class=\"right\">Rarity:</th>
      <td>" . $_SESSION['card']['r'] . "</td>";
      ?>
    </tr>
  </table>
</div>
