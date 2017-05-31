<?php
  function adding_to_title($page_name) {
    switch ($page_name) {
      case 'want':
      case 'trade':
        $page_name .= "list";

        break;
    }
    return ucfirst($page_name);
  }

  function qty_inputs($page) {
    switch ($page) {
      case 'want':
        return "<div class=\"input-field col s2\">
          <input type=\"text\" value=\"1\" id=\"want_qty\" onchange=\"remove_nonnumbers(this, this.value);\"/>
          <label for=\"want_qty\">Want Qty</label>
        </div>";
      case 'inventory':
        return "<div class=\"input-field col s2\">
          <input type=\"text\" value=\"1\" id=\"inventory_qty\" onchange=\"remove_nonnumbers(this, this.value);\"/>
          <label for=\"inventory_qty\">Add Qty</label>
        </div>";
      case 'trade':
        return "<div class=\"input-field col s2\">
          <input type=\"text\" value=\"1\" id=\"trade_qty\" onchange=\"remove_nonnumbers(this, this.value);\"/>
          <label for=\"trade_qty\">Trade</label>
        </div>";
    }
  }

  function condition_select() {
    global $db;
    $prep = $db->prepare("SELECT id, code from conditions");
    $prep->execute();
    echo "<select id=\"condition_select\">\n";
    foreach ($prep->fetchAll() as $cond) {
      echo "<option value=\"" . $cond['id'] . "\">" . $cond['code'] . "</option>\n";
    }
    echo "</select>\n";
  }
?>
<div class="fixed-action-btn horizontal click-to-toggle">
  <a href="#add_card_modal" class="btn-floating btn-large green lighten-2">
    <i class="material-icons">add</i>
  </a>
</div>

<div class="modal blue-grey lighten-5 center" id="add_card_modal">
  <div class="modal-content container center">
    <h4>Add Card To <?php echo adding_to_title($page); ?></h4>
    <div class="row">
      <div class="input-field col s10">
        <!-- Turn off browser autocomplete and use my own -->
        <input type="text" id="card_name" name="cn" class="autocomplete" autocomplete="off">
        <label for="card_name">Card Name</label>
      </div>
      <div class="input-field col s1">
        <a onclick="populate_versions($('#card_name').val());" id="search"
           class="btn waves-effect waves-purple green green-text text-lighten-5">
          <i class="material-icons">search</i>
        </a>
      </div>
    </div>
    <div id="card_details" class="row hide">
      <?php echo qty_inputs($page); ?>
      <div class="input-field col s6">
        <select class="icons" name="version" id="version">
        </select>
        <label for="version">Version</label>
      </div>
      <div class="input-field col s2">
        <?php condition_select(); ?>
        <label for="condition_select">Condition</label>
      </div>
      <div class="input-field col s2">
        <select id="foil_select">
          <option value="false">No</option>
          <option value="true">Foil</option>
        </select>
        <label for="condition_select">Foil</label>
      </div>
      <div class="row">
        <div class="col s4 offset-s4">
          <img id="selected-image" class="responsive-card" src="" alt="Card Preview" />
        </div>
      </div>
    </div>
    <div class="row hide" id="no_match">
      <div class="col s12 blue-grey-text text-lighten-1">
        <p id="error_text"></p>
      </div>
    </div>
  </div>
  <div class="modal-footer container center blue-grey lighten-5">
    <div class="row">
      <div class="col s4 offset-s2">
        <a id="add_button" class="waves-effect waves-effect waves-purple green green-text text-lighten-5 btn disabled"
           onclick=<?php echo "\"adding_ajax('$page');\""; ?>>Add Cards<i class="material-icons right">done</i></a>
      </div>
      <div class="col s3">
        <a href="#!" class="modal-action modal-close waves-effect waves-red red green-text text-lighten-5 btn">
          Close<i class="material-icons right">close</i>
        </a>
      </div>
    </div>
  </div>
</div>
