<?php
  if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    require_once("moving_page.php");
    require_once("../sql/midl.php");
  }

  function wantlist_count() {
    global $db;
    $stmt = $db->prepare("SELECT totalwanted AS tw, distinctwanted AS dw FROM wantlists WHERE collectorid = :cid");
    $stmt->execute(array(':cid' => $_SESSION["collector_id"]));
    $want_totals = $stmt->fetch();
    return "<h6>Total Wanted: " . $want_totals['tw'] ." — Distinct Wanted: " . $want_totals['dw'] . "</h6>";
  }

  function wantlist_count_display() {
    echo wantlist_count();
  }

  function format_time($timestamp, $format = 'd M Y')
  {
    $formatted_timestamp = date($format, strtotime($timestamp));
    return $formatted_timestamp;
  }

  function get_rows() {
    $wantlist = grab_wantlist();
    if (empty($wantlist)) {
      return "<tr><td colspan=\"7\">You have nothing in your inventory</td></tr>";
    }
    $results = "";
    foreach ($wantlist as $item) {
      $results .=
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
         <td>" . $item['type1'] . ((!empty($item['type2'])) ? " " . $item['type2'] : "" ) . "</td>
         <td>" . $item['rarity'] . "</td>
         <td>" . format_time($item['modified']) . "</td>
       </tr>";
    }
    return $results;
  }

  function &grab_wantlist() {
    if (isset($_SESSION['wantlist'])) {
      return $_SESSION['wantlist'];
    }
    global $db;
    $prep = $db->prepare("SELECT id FROM wantlists WHERE collectorid = :cid");
    $prep->execute(array(':cid' => $_SESSION["collector_id"]));
    $want_id = $prep->fetchColumn();
    $prep = $db->prepare(
      "SELECT wc.qty, c.name, s.code AS set, sc.numinset AS num, cons.code as condition, wc.foil,
      (SELECT name
       FROM types AS t
       WHERE c.typeid1 = t.id) AS type1,
       (SELECT name
        FROM types AS t
        WHERE c.typeid2 = t.id) AS type2, r.type as rarity, wc.modified, sc.imageurl
    FROM wantcontents AS wc, specificcards AS sc, cards AS c, sets AS s, rarities AS r, conditions AS cons
    WHERE wc.wantlistid = :wantid AND sc.id = wc.specificcardid AND sc.cardid = c.id
    AND s.id = sc.setid AND wc.conditionid = cons.id AND r.id = sc.rarityid
    ORDER BY c.name");
    $prep->execute(array(':wantid' => $want_id));

    $_SESSION['wantlist'] = $prep->fetchAll();
    return $_SESSION['wantlist'];
  }

  function get_table() {
    return "<table class=\"striped highlight responsive-table\">
      <thead>
        <tr>
          <th>Want Qty</th>
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
    $results = array('totals' => wantlist_count(), 'table' => get_table());
    echo json_encode($results);
  }
?>
