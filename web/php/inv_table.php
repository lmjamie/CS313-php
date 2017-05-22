<?php
  function format_time($timestamp, $format = 'd M Y')
  {
    $formatted_timestamp = date($format, strtotime($timestamp));
    return $formatted_timestamp;
  }

  function print_rows() {
    $inventory = grab_inventory();
    if (empty($inventory)) {
      echo "<tr><td colspan=\"7\">You have nothing in your inventory</td></tr>";
      return;
    }
    foreach ($inventory as $item) {
      echo
      "<tr>
         <td>" . $item['qty'] . "</td>
         <td>" . $item['name'] . "</td>
         <td>" . $item['set'] . "</td>
         <td>" . $item['condition'] . " / " . (($item['foil']) ? "T" : "F") . "</td>
         <td>" . $item['type1'] . ((!empty($item['type2'])) ? " " . $item['type2'] : "" ) . "</td>
         <td>" . $item['rarity'] . "</td>
         <td>" . format_time($item['modified']) . "</td>
       </tr>";
    }

  }

  function grab_inventory() {
    global $db;
    $prep = $db->prepare("SELECT id FROM inventories WHERE collectorid = :cid");
    $prep->execute(array(':cid' => $_SESSION["collector_id"]));
    $inv_id = $prep->fetchColumn();
    $prep = $db->prepare(
      "SELECT ic.qty, c.name, s.code AS set, cons.code as condition, ic.foil,
      (SELECT name
       FROM types AS t
       WHERE c.typeid1 = t.id) AS type1,
       (SELECT name
        FROM types AS t
        WHERE c.typeid2 = t.id) AS type2, r.type as rarity, ic.modified, sc.imageurl
    FROM inventorycontents AS ic, specificcards AS sc, cards AS c, sets AS s, rarities AS r, conditions AS cons
    WHERE ic.inventoryid = :invid AND sc.id = ic.specificcardid AND sc.cardid = c.id
    AND s.id = sc.setid AND ic.conditionid = cons.id AND r.id = sc.rarityid
    ORDER BY c.name");
    $prep->execute(array(':invid' => $inv_id));
    return $prep->fetchAll();
  }
?>
<table class="striped highlight responsive-table">
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
    <?php print_rows(); ?>
  </tbody>
</table>
