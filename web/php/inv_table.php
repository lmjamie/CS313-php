<?php
  if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    require_once("moving_page.php");
    require_once("../sql/midl.php");
  }

  function inventory_count() {
    global $db;
    $stmt = $db->prepare("SELECT totalcards AS tc, distinctcards AS dc FROM inventories WHERE collectorid = :cid");
    $stmt->execute(array(':cid' => $_SESSION["collector_id"]));
    $inv_totals = $stmt->fetch();
    return "<h6>Total Cards: " . $inv_totals['tc'] ." — Distinct Cards: " . $inv_totals['dc'] . "</h6>";
  }

  function inventory_count_display() {
    echo inventory_count();
  }

  function format_time($timestamp, $format = 'd M Y')
  {
    $formatted_timestamp = date($format, strtotime($timestamp));
    return $formatted_timestamp;
  }

  function get_type_line($spt1, $spt2, $t1, $t2, $sbt1, $sbt2, $sbt3, $sbt4) {
    return (!empty($spt1) ? $spt1 . " " : "") . (!empty($spt2) ? $spt2 . " " : "") .
           $t1 . (!empty($t2) ? " " . $t2 : "") . (!empty($sbt1) ? " — " . $sbt1 : "") .
           (!empty($sbt2) ?  " " . $sbt2 : "") . (!empty($sbt3) ?  " " . $sbt3 : "") .
           (!empty($sbt4) ?  " " . $sbt4 : "") ;
  }

  function get_rows() {
    $inventory = grab_inventory();
    if (empty($inventory)) {
      return "<tr><td colspan=\"7\">You have nothing in your inventory</td></tr>";
    }
    $rows = "";
    foreach ($inventory as $item) {
      $rows .=
      "<tr>
         <td>" . $item['qty'] . "</td>
         <td>
         <a class=\"tooltipped\" onclick=\"card_details(this);\" value=\"" . $item['set'] . "\"
          data-num=\"" . $item['num'] . "\" data-position=\"top\" data-delay=\"50\" data-html=\"true\"
          data-tooltip=\"<img src='". $item['imageurl'] . "' alt='" . $item['name'] . "' />\">"
          . $item['name'] .
        "</a></td>
         <td>" . $item['set'] . "</td>
         <td>" . $item['condition'] . " / " . (($item['foil']) ? "T" : "F") . "</td>
         <td>" .
         get_type_line($item['supertype1'], $item['supertype2'], $item['type1'],
                       $item['type2'], $item['subtype1'], $item['subtype2'],
                       $item['subtype3'], $item['subtype4']) .
        "</td>
         <td>" . $item['rarity'] . "</td>
         <td>" . format_time($item['modified']) . "</td>
       </tr>";
    }
    return $rows;
  }

  function &grab_inventory() {
    if (isset($_SESSION['inventory'])) {
      return $_SESSION['inventory'];
    }
    global $db;
    $prep = $db->prepare("SELECT id FROM inventories WHERE collectorid = :cid");
    $prep->execute(array(':cid' => $_SESSION["collector_id"]));
    $inv_id = $prep->fetchColumn();
    $prep = $db->prepare(
      "SELECT ic.qty, c.name, s.code AS set, sc.numinset as num, cons.code as condition, ic.foil,
      (SELECT name
       FROM types t
       WHERE c.typeid1 = t.id) AS type1,
       (SELECT name
        FROM types t
        WHERE c.typeid2 = t.id) AS type2,
       (SELECT name
        FROM supertypes st
        WHERE c.supertypeid1 = st.id) AS supertype1,
       (SELECT name
        FROM supertypes st
        WHERE c.supertypeid2 = st.id) AS supertype2,
       (SELECT name
        FROM subtypes sbt
        WHERE c.subtypeid1 = sbt.id) AS subtype1,
       (SELECT name
        FROM subtypes sbt
        WHERE c.subtypeid2 = sbt.id) AS subtype2,
       (SELECT name
        FROM subtypes sbt
        WHERE c.subtypeid3 = sbt.id) AS subtype3,
       (SELECT name
        FROM subtypes sbt
        WHERE c.subtypeid4 = sbt.id) AS subtype4,
         r.type AS rarity, ic.modified, sc.imageurl
    FROM inventorycontents ic, specificcards sc, cards c, sets s, rarities r, conditions cons
    WHERE ic.inventoryid = :invid AND sc.id = ic.specificcardid AND sc.cardid = c.id
    AND s.id = sc.setid AND ic.conditionid = cons.id AND r.id = sc.rarityid
    ORDER BY c.name");
    $prep->execute(array(':invid' => $inv_id));
    $_SESSION['inventory'] = $prep->fetchAll();
    return $_SESSION['inventory'];
  }

  function get_table() {
    return "<table class=\"striped highlight responsive-table\">
      <thead>
        <tr>
          <th>Qty</th>
          <th>Name</th>
          <th>Set</th>
          <th>Con / Foil</th>
          <th>Type</th>
          <th>Rarity</th>
          <th>Modified</th>
        </tr>
      </thead>
      <tbody>
       " . get_rows() . "
      </tbody>
    </table>";
  }

  function print_table() {
    echo get_table();
  }

  if(isset($_POST["update"])) {
    unset($_POST["update"]);
    header('Content-Type: application/json');
    $results = array('totals' => inventory_count(), 'table' => get_table());
    echo json_encode($results);
  }
?>
