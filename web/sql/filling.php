<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Test Fill</title>
</head>

<body>
  <?php

    require("../../vendor/autoload.php");
    require_once("midl.php");
    use mtgsdk\Type;
    use mtgsdk\Supertype;
    use mtgsdk\Subtype;
    use mtgsdk\Set;
    use mtgsdk\Card;
    function insert_type($type) {
      global $db;
      $stmt = $db->prepare('INSERT INTO types (name) VALUES (:type)
      ON CONFLICT DO NOTHING');
      $stmt->execute(array(':type' => $type));
    }

    function insert_supertype($supertype) {
      global $db;
      $stmt = $db->prepare('INSERT INTO supertypes (name) VALUES (:supertype)
      ON CONFLICT DO NOTHING');
      $stmt->execute(array(':supertype' => $supertype));
    }

    function insert_subtype($subtype) {
      global $db;
      $stmt = $db->prepare('INSERT INTO subtypes (name) VALUES (:subtype)
      ON CONFLICT DO NOTHING');
      $stmt->execute(array(':subtype' => $subtype));
    }

    function fill_types() {
      $types = Type::all();
      foreach ($types as $t) {
        echo "<p>Now inserting $t >>> types table</p>\n";
        insert_type($t);
      }
    }

    function fill_supertypes() {
      $supertypes = Supertype::all();
      foreach ($supertypes as $st) {
        echo "<p>Now inserting $st >>> supertypes table</p>\n\n";
        insert_supertype($st);
      }
    }

    function fill_subtypes() {
      $subtypes = Subtype::all();
      foreach ($subtypes as $sub) {
        echo "<p>Now inserting $sub >>> subtypes table</p>\n\n";
        insert_subtype($sub);
      }
    }

    function insert_condition($condition) {
      global $db;
      $stmt = $db->prepare('INSERT INTO conditions (code) VALUES (:condition)
      ON CONFLICT DO NOTHING');
      $stmt->execute(array(':condition' => $condition));
    }

    function insert_rarity($rarity) {
      global $db;
      $stmt = $db->prepare('INSERT INTO rarities (type) VALUES (:rarity)
      ON CONFLICT DO NOTHING');
      $stmt->execute(array(':rarity' => $rarity));
    }

    function insert_set($set) {
      global $db;
      $stmt = $db->prepare('INSERT INTO sets (code, name) VALUES (:code, :name)
      ON CONFLICT DO NOTHING');
      $stmt->execute(array(':code' => $set->__get("code"), ':name' => $set->__get("name")));
    }

    function fill_conditions() {
      $conditions = array('NM/M', 'LP', 'MP', 'HP', 'D');
      foreach ($conditions as $con) {
        echo "<p>Now inserting $con >>> conditions table</p>\n\n";
        insert_condition($con);
      }
    }

    function fill_rarities() {
      $rarities = array("Common", "Uncommon", "Rare", "Mythic Rare", "Special", "Basic Land");
      foreach ($rarities as $rar) {
        echo "<p>Now inserting $rar >>> rarities table</p>\n\n";
        insert_rarity($rar);
      }
    }

    function fill_sets() {
      $sets = Set::all();
      foreach ($sets as $set) {
        echo "<p>Now inserting " . $set->__get("name") . " >>> sets table</p>\n\n";
        insert_set($set);
      }
    }

    function fill_all() {
      fill_sets();
      fill_rarities();
      fill_conditions();
      fill_types();
      fill_supertypes();
      fill_subtypes();
    }

    function color_handler($colors) {
      if (empty($colors)) {
        return array(6);
      }
      foreach ($colors as $c) {
        switch ($c) {
          case 'White':
            $return[] = 1;
            break;
          case 'Blue':
            $return[] = 2;
            break;
          case 'Black':
            $return[] = 3;
            break;
          case 'Red':
            $return[] = 4;
            break;
          case 'Green':
            $return[] = 5;
            break;
        }
      }
      return $return;
    }

    function type_handler($types, $stmt) {
      global $db;
      foreach ($types as $type) {
        $stmt->execute(array(':type' => $type));
        $return[] = $stmt->fetchColumn();
      }
      return $return;
    }

    function supertype_handler($supertypes, $stmt) {
      if (empty($supertypes)) {
        return array();
      }
      global $db;
      foreach ($supertypes as $st) {
        $stmt->execute(array(':st' => $st));
        $return[] = $stmt->fetchColumn();
      }
      return $return;
    }

    function subtype_handler($subtypes, $stmt) {
      if (empty($subtypes)) {
        return array();
      }
      global $db;
      foreach ($subtypes as $st) {
        $stmt->execute(array(':st' => $st));
        $return[] = $stmt->fetchColumn();
      }
      return $return;
    }

    function rarity_handler($rarity, $stmt) {
      global $db;
      $stmt->execute(array(':type' => $rarity));
      return $stmt->fetchColumn();
    }

    function set_handler($set, $stmt) {
      global $db;
      $stmt->execute(array(':code' => $set));
      return $stmt->fetchColumn();
    }

    function get($card, $to_get) {
      try {
        return $card->__get($to_get);
      } catch (Exception $e) {
        return NULL;
      }

    }

    function insert_card($card, $prep) {
      global $db;
      $name = get($card, "name");
      $prep['test_prep']->execute(array(':name' => $name));
      $test = $prep['test_prep']->fetch();
      // if card is already inserted just get the id
      if ($test) {
        $card_id = $test['id'];
      } else {
        // otherwise insert it and get the id.
        $cmc = get($card, "cmc");
        $manacost = get($card, "manaCost");
        $colors = color_handler(get($card, "colors"));
        $types = type_handler(get($card, "types"), $prep['type_stmt']);
        $supertypes = supertype_handler(get($card, "supertypes"), $prep['supertype_stmt']);
        $subtypes = subtype_handler(get($card, "subtypes"), $prep['subtype_stmt']);
        $rules = get($card, "text");
        $power = get($card, "power");
        $toughness = get($card, "toughness");
        $loyalty = get($card, "loyalty");
        $prep['card_insert']->execute(array(
          ':name' => $name, ':cmc' => $cmc, ':manacost' => $manacost, ':colorid1' => $colors[0],
          ':colorid2' => $colors[1], ':colorid3' => $colors[2], ':colorid4' => $colors[3],
          ':colorid5' => $colors[4], ':typeid1' => $types[0], ':typeid2' => $types[1],
          ':supertypeid1' => $supertypes[0], ':supertypeid2' => $supertypes[1],
          ':subtypeid1' => $subtypes[0], ':subtypeid2' => $subtypes[1], ':subtypeid3' => $subtypes[2],
          ':subtypeid4' => $subtypes[3], ':rules' => $rules, ':power' => $power,
          ':toughness' => $toughness, ':loyalty' => $loyalty));
        $card_id = $db->lastInsertId();
      }

      $flavor = get($card, "flavor");
      $imageurl = get($card, "imageUrl");
      $rarity = rarity_handler(get($card, "rarity"), $prep['rarity_stmt']);
      $num = get($card, "number");
      $set = set_handler(get($card, "set"), $prep['set_stmt']);
      $prep['scard_insert']->execute(array(
        ':flavor' => $flavor, ':imageurl' => $imageurl, ':rarityid' => $rarity,
        ':numinset' => $num, ':setid' => $set, ':cardid' => $card_id));
      if (empty($prep['scard_insert']->errorCode())) { var_dump($prep['scard_insert']->errorInfo);}
      echo "<p>Inserted card $name from $set</p>";
    }


    function fill_cards($num = 5) {
      global $db;
      $cards = Card::where(['set' => 'lea|akh'])->all();
      $prep = array('test_prep' => $db->prepare("SELECT id FROM cards WHERE name = :name"),
      'card_insert' => $db->prepare(
        "INSERT INTO
        cards(name, cmc, manacost, colorid1, colorid2, colorid3, colorid4, colorid5,
              typeid1, typeid2, supertypeid1, supertypeid2, subtypeid1, subtypeid2,
              subtypeid3, subtypeid4, rules, power, toughness, loyalty)
        VALUES (:name, :cmc, :manacost, :colorid1, :colorid2, :colorid3, :colorid4,
                :colorid5, :typeid1, :typeid2, :supertypeid1, :supertypeid2,
                :subtypeid1, :subtypeid2, :subtypeid3, :subtypeid4, :rules, :power,
                :toughness, :loyalty)"),
      'scard_insert' => $db->prepare(
        "INSERT INTO specificcards(flavor, imageurl, rarityid, numinset, setid, cardid)
        VALUES(:flavor, :imageurl, :rarityid, :numinset, :setid, :cardid) ON CONFLICT DO NOTHING"),
      'set_stmt' => $db->prepare("SELECT id FROM sets WHERE code = :code"),
        'type_stmt' => $db->prepare("SELECT id FROM types WHERE name = :type"),
      'supertype_stmt' => $db->prepare("SELECT id FROM supertypes WHERE name = :st"),
      'subtype_stmt' => $db->prepare("SELECT id FROM subtypes WHERE name = :st"),
      'rarity_stmt' => $db->prepare("SELECT id FROM rarities WHERE type = :type"));
      foreach ($cards as $card) {
        insert_card($card, $prep);
      }
    }
    

  ?>
</body>

</html>
