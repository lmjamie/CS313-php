<?php
  if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    require_once("moving_page.php");
    require_once("../sql/midl.php");
  }

  function tradelist_count() {
    global $db;
    $stmt = $db->prepare("SELECT tl.totaltrade as tt, tl.distincttrade as dt
      FROM tradelists AS tl, inventories AS i
      WHERE i.collectorid = :cid AND tl.inventoryid = i.id");
    $stmt->execute(array(':cid' => $_SESSION["collector_id"]));
    $trade_totals = $stmt->fetch();
    return "<h6>Total Trades: " . $trade_totals['tt'] ." — Distinct Trades: " . $trade_totals['dt'] . "</h6>";
  }

  function tradelist_count_display() {

    echo tradelist_count();
  }

  function format_time($timestamp, $format = 'd M Y')
  {
    $formatted_timestamp = date($format, strtotime($timestamp));
    return $formatted_timestamp;
  }

  function get_rows() {
    $tradelist = grab_tradelist();
    if (empty($tradelist)) {
      return "<tr><td colspan=\"7\">You have nothing in your tradelist</td></tr>";
    }
    $results = "";
    foreach ($tradelist as $item) {
      $results .=
      "<tr>
         <td>" . $item['tqty'] . "</td>
         <td>" . $item['iqty'] . "</td>
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

  function &grab_tradelist() {
    if (isset($_SESSION['tradelist'])) {
      return $_SESSION['tradelist'];
    }
    global $db;
    $prep = $db->prepare("SELECT id FROM inventories WHERE collectorid = :cid");
    $prep->execute(array(':cid' => $_SESSION["collector_id"]));
    $inv_id = $prep->fetchColumn();
    $prep = $db->prepare("SELECT id FROM tradelists WHERE inventoryid = :invid");
    $prep->execute(array(':invid' => $inv_id));
    $trade_id = $prep->fetchColumn();
    $prep = $db->prepare(
      "SELECT tc.qty AS tqty, ic.qty AS iqty, c.name, s.code AS set, sc.numinset AS num,
         cons.code AS condition, ic.foil,
      (SELECT name
       FROM types AS t
       WHERE c.typeid1 = t.id) AS type1,
      (SELECT name
       FROM types AS t
       WHERE c.typeid2 = t.id) AS type2, r.type as rarity, ic.modified, sc.imageurl
       FROM inventorycontents AS ic, specificcards AS sc, cards AS c, sets AS s,
        rarities AS r, conditions AS cons, tradecontents AS tc
       WHERE ic.id = tc.inventorycontentid AND sc.id = ic.specificcardid AND sc.cardid = c.id
       AND s.id = sc.setid AND ic.conditionid = cons.id AND r.id = sc.rarityid
       AND tc.tradelistid = :tradeid
       ORDER BY c.name");
    $prep->execute(array(':tradeid' => $trade_id));
    $_SESSION['tradelist'] = $prep->fetchAll();
    return $_SESSION['tradelist'];
  }

  function get_table() {
    return "<table class=\"striped highlight responsive-table\">
      <thead>
        <tr>
          <th>Trade Qty</th>
          <th>Inv Qty</th>
          <th>Name</th>
          <th>Set</th>
          <th>Con / Foil</th>
          <th>Type</th>
          <th>Rarity</th>
          <th>Modified</th>
        </tr>
      </thead>
      <tbody> "
        . get_rows() . "
      </tbody>
    </table>";
  }

  function print_table() {
    echo get_table();
  }

  if(isset($_POST["update"])) {
    unset($_POST["update"]);
    header('Content-Type: application/json');
    $results = array('totals' => tradelist_count(), 'table' => get_table());
    echo json_encode($results);
  }
?>
