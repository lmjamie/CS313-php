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
    var_dump(scandir("vendor"));
  //  require("vendor/autoload.php");
    die();
    require_once("midl.php");
    use mtgsdk\Type;
    use mtgsdk\Supertype;
    use mtgsdk\Subtype;
    use mtgsdk\Set;

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

    fill_all();
  ?>
</body>
</html>
