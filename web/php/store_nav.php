<?php
  $page = basename($_SERVER['PHP_SELF'], ".php");
  ?>
  <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper green lighten-1">
        <a href="homepage.php" class="left brand-logo waves-effect waves-purple">
          <i class="material-icons right">person_pin</i> Landon Jamieson
        </a>
        <ul class="right">
          <li <?php if ($page=="cart" ) { echo "class=\"active\""; } ?> ><a class="waves-effect waves-purple" href="cart.php"><i class="material-icons">shopping_cart</i></a></li>
        </ul>
        <ul class="right hide-on-med-and-down">
          <li><a href="assign.php" class="waves-effect waves-purple"><i class="material-icons left">play_for_work</i>Assignments</a></li>
          <li <?php if ($page=="store" ) { echo "class=\"active\""; } ?> ><a href="store.php" class="waves-effect waves-purple"><i class="material-icons left">store</i>Browse Store</a></li>
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
            <a href="store.php" class="flow-text white-text">
              <i class="material-icons flow-text white-text left">store</i> Browse
            </a>
          </li>
      </div>
    </nav>
  </div>
