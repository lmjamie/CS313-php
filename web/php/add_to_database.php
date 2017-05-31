<?php
  require("moving_page.php");
  require("../sql/midl.php");
  $needed = array("type", "scid", "qty", "cond", "foil");

  function validate_post_data() {
    global $db;
    //check type
    switch ($_POST['type']) {
      case 'trade':
      case 'want':
      case 'inventory':
        break;
      default:
        move_if_not_set_in_post("NeVeREvErSeT", "../inventory.php", "Invalid Type", true);
    }

    //check scid
    $check_prep = $db->prepare("SELECT id FROM specificcards WHERE id = :scid");
    $check_prep->execute(array(':scid' => $_POST['scid']));
    if (!$check_prep->fetch()) {
      move_if_not_set_in_post("NeVeREvErSeT", "../" . $_POST['type'] . ".php", "Invalid Scid", true);
    }

    //check cond
    $check_prep = $db->prepare("SELECT id FROM conditions WHERE id = :cond");
    $check_prep->execute(array(':cond' => $_POST['cond']));
    if (!$check_prep->fetch()) {
      move_if_not_set_in_post("NeVeREvErSeT", "../" . $_POST['type'] . ".php", "Invalid Condition", true);
    }

    //check foil
    if ($_POST['foil'] !== 'false' && $_POST['foil'] !== 'true') {
      move_if_not_set_in_post("NeVeREvErSeT", "../" . $_POST['type'] . ".php", "Invalid Foil", true);
    }

    //check qty
    $_POST['qty'] = intval(preg_replace('/\D/', '', $_POST['qty']));

    //first if trade
    if ($_POST['type'] === "trade") {
      $check_prep = $db->prepare(
        "SELECT tl.id AS tlid, tc.id AS tcid, ic.id AS icid, ic.qty AS inv_qty,
                tc.qty AS trade_qty
        FROM inventorycontents ic
        JOIN inventories i ON i.id = ic.inventoryid
        LEFT JOIN tradecontents tc ON ic.id = tc.inventorycontentid
        LEFT JOIN tradelists tl ON i.id = tl.inventoryid
        WHERE i.collectorid = :cid AND ic.specificcardid = :scid AND
              ic.conditionid = :cond AND ic.foil = :foil"
      );
      $check_prep->execute(array(
        ':cid' => $_SESSION['collector_id'], ':scid' => $_POST['scid'],
        ':cond' => $_POST['cond'], ':foil' => $_POST['foil']
      ));
      $check_fetch = $check_prep->fetch();
      if ($check_fetch) {
        $inv_qty = $check_fetch['inv_qty'];
        $trade_qty_old = (!empty($check_fetch['trade_qty'])) ? $check_fetch['trade_qty'] : 0 ;
        $_SESSION['trade_qty_old'] = $trade_qty_old;
        $_SESSION['tcid'] = $check_fetch['tcid'];
        $_SESSION['tlid'] = $check_fetch['tlid'];
        $_SESSION['icid'] = $check_fetch['icid'];
        $_POST['qty'] = min($inv_qty - $trade_qty_old, $_POST['qty']);
      } else {
        $_POST['qty'] = 0;
      }
    }

    //then for everything
    if ($_POST['qty'] == 0) {
      move_if_not_set_in_post("NeVeREvErSeT", "../" . $_POST['type'] . ".php", "Nothing To Add", true);
    }
  }

  function check_adding_post() {
    global $needed;
    $error = "Post Data Error";
    foreach ($needed as $test) {
      move_if_not_set_in_post($test, "../inventory.php", $error, true);
    }
    validate_post_data();
  }

  function add_to_database() {
    global $db;
    switch ($_POST['type']) {
      case 'want':
        unset($_SESSION['wantlist']);
        $prep = $db->prepare("SELECT id FROM wantlists WHERE collectorid = :cid");
        $prep->execute(array(':cid' => $_SESSION['collector_id']));
        $wlid = $prep->fetchColumn();
        $prep_check = $db->prepare(
          "SELECT wc.id FROM wantcontents wc
          JOIN wantlists wl ON wl.id = wc.wantlistid
          WHERE wl.collectorid = :cid AND wc.specificcardid = :scid
          AND wc.conditionid = :cond AND wc.foil = :foil"
        );
        $prep_check->execute(array(
          ':cid' => $_SESSION['collector_id'], ':scid' => $_POST['scid'],
          ':cond' => $_POST['cond'], ':foil' => $_POST['foil']
        ));
        $fetch_check = $prep_check->fetch();
        if (!$fetch_check) {
          // insert
          $distinct_add = 1;
          $prep = $db->prepare(
            "INSERT INTO wantcontents(qty, foil, modified, conditionid, specificcardid, wantlistid)
            VALUES (:qty, :foil, now(), :cond, :scid, :wlid)"
          );
          $prep->execute(array(
            ':qty' => $_POST['qty'], ':foil' => $_POST['foil'],
            ':cond' => $_POST['cond'], ':scid' => $_POST['scid'], ':wlid' => $wlid
          ));
        } else {
          //update
          $distinct_add = 0;
          $wcid = $fetch_check['id'];
          $prep = $db->prepare(
            "UPDATE wantcontents
            SET qty = qty + :qty, modified = now()
            WHERE id = :wcid"
          );
          $prep->execute(array(':qty' => $_POST['qty'], ':wcid' => $wcid));
        }
        $prep = $db->prepare(
          "UPDATE wantlists
          SET totalwanted = totalwanted + :qty, distinctwanted = distinctwanted + :d_add
          WHERE id = :wlid"
        );
        $prep->execute(array(':qty' => $_POST['qty'], ':d_add' => $distinct_add, ':wlid' => $wlid));
        break;
      case 'trade':
        unset($_SESSION['tradelist']);
        $tlid = $_SESSION['tlid'];
        if ($_SESSION['trade_qty_old'] == 0) {
          // insert
          $distinct_add = 1;
          $icid = $_SESSION['icid'];
          $prep = $db->prepare(
            "INSERT INTO tradecontents(qty, modified, inventorycontentid, tradelistid)
            VALUES (:qty, now(), :icid, :tlid)"
          );
          $prep->execute(array(':qty' => $_POST['qty'], ':icid' => $icid, ':tlid' => $tlid));

        } else {
          //update
          $tcid = $_SESSION['tcid'];
          $distinct_add = 0;
          $prep = $db->prepare(
            "UPDATE tradecontents
            SET qty = qty + :qty, modified = now()
            WHERE id = :tcid"
          );
          $prep->execute(array(':qty' => $_POST['qty'], ':tcid' => $tcid));
        }
        $prep = $db->prepare(
          "UPDATE tradelists
          SET totaltrade = totaltrade + :qty, distincttrade = distincttrade + :d_add
          WHERE id = :tlid"
        );
        $prep->execute(array(':qty' => $_POST['qty'], ':d_add' => $distinct_add, ':tlid' => $tlid));
        break;
      case 'inventory':
        unset($_SESSION['inventory']);
        $prep = $db->prepare("SELECT id FROM inventories WHERE collectorid = :cid");
        $prep->execute(array(':cid' => $_SESSION['collector_id']));
        $iid = $prep->fetchColumn();
        $prep_check = $db->prepare(
          "SELECT ic.id FROM inventorycontents ic
          JOIN inventories i ON i.id = ic.inventoryid
          WHERE i.collectorid = :cid AND ic.specificcardid = :scid
          AND ic.conditionid = :cond AND ic.foil = :foil"
        );
        $prep_check->execute(array(
          ':cid' => $_SESSION['collector_id'], ':scid' => $_POST['scid'],
          ':cond' => $_POST['cond'], ':foil' => $_POST['foil']
        ));
        $fetch_check = $prep_check->fetch();
        if (!$fetch_check) {
          // insert
          $distinct_add = 1;
          $prep = $db->prepare(
            "INSERT INTO inventorycontents(qty, foil, modified, conditionid, specificcardid, inventoryid)
            VALUES (:qty, :foil, now(), :cond, :scid, :iid)"
          );
          $prep->execute(array(
            ':qty' => $_POST['qty'], ':foil' => $_POST['foil'],
            ':cond' => $_POST['cond'], ':scid' => $_POST['scid'], ':iid' => $iid
          ));
        } else {
          //update
          $icid = $fetch_check['id'];
          $distinct_add = 0;
          $prep = $db->prepare(
            "UPDATE inventorycontents
            SET qty = qty + :qty, modified = now()
            WHERE id = :icid"
          );
          $prep->execute(array(':qty' => $_POST['qty'], ':icid' => $icid));
        }
        $prep = $db->prepare(
          "UPDATE inventories
          SET totalcards = totalcards + :qty, distinctcards = distinctcards + :d_add
          WHERE id = :iid"
        );
        $prep->execute(array(':qty' => $_POST['qty'], ':d_add' => $distinct_add, ':iid' => $iid));
        break;
    }
  }

  check_adding_post();
  add_to_database();

?>
