<?php
  $page = basename($_SERVER['PHP_SELF'], ".php");
  ?>
  <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper green lighten-1">
        <a href="homepage.php" class="left brand-logo waves-effect waves-purple">
          <i class="material-icons right">person_pin</i> Landon Jamieson
        </a>
        <ul class="right hide-on-med-and-down">
          <li><a href="assign.php" class="waves-effect waves-purple"><i class="material-icons left">play_for_work</i>Assignments</a></li>
          <li <?php if ($page=="inventory" ) { echo "class=\"active\""; } ?> ><a href="inventory.php" class="waves-effect waves-purple"><i class="material-icons left">storage</i>Inventory</a></li>
          <li <?php if ($page=="trade" ) { echo "class=\"active\""; } ?>><a href="trade.php" class="waves-effect waves-purple">Tradelist<i class="material-icons left">swap_horiz</i></a></li>
          <li <?php if ($page=="want" ) { echo "class=\"active\""; } ?>><a href="want.php" class="waves-effect waves-purple">Wantlist<i class="material-icons left">playlist_add_check</i></a></li>
          <?php if (isset($_SESSION["username"])) { echo "<li><a href=\"php/logout.php\" class=\"waves-effect waves-red\">Logout<i class=\"material-icons left\">highlight_off</i></a></li>"; } ?>
        </ul>
        <a class="button-collapse right" href="#" data-activates="mobile-menu">
          <i class="material-icons">menu</i>
        </a>
        <ul id="mobile-menu" class="right green lighten-1 side-nav">
          <li>
            <a href="assign.html" class="flow-text white-text">
              <i class="material-icons flow-text white-text left">play_for_work</i> Assignments
            </a>
          </li>
          <li>
            <a href="inventory.php" class="flow-text white-text">
              <i class="material-icons flow-text white-text left">storage</i> Inventory
            </a>
          </li>
          <li>
            <a href="trade.php" class="flow-text white-text">
              <i class="material-icons flow-text white-text left">swap_horiz</i> Tradelist
            </a>
          </li>
          <li>
            <a href="want.php" class="flow-text white-text">
              <i class="material-icons flow-text white-text left">playlist_add_check</i> Wantlist
            </a>
          </li>
          <?php
            if (isset($_SESSION["username"])) {
              echo
              "<li>
                <a href=\"php/logout.php\" class=\"flow-text white-text\">Logout
                  <i class=\"material-icons flow-text white-text left\">highlight_off</i>
                </a>
              </li>"; } ?>
      </div>
    </nav>
  </div>
