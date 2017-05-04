<?php
$page = basename($_SERVER['PHP_SELF'], ".php");
?>
  <nav>
    <div class="nav-wrapper green lighten-1">
      <a href="homepage.php" class="left brand-logo">
        <i class="material-icons right">person_pin</i> Landon Jamieson
      </a>
      <a class="button-collapse right" href="#" data-activates="mobile-menu">
        <i class="material-icons">menu</i>
      </a>
      <ul class="right hide-on-med-and-down">
        <li <?php if ($page=="assign" ) { echo "class='active'"; } ?> ><a href="assign.php"><i class="material-icons left">play_for_work</i>Assignments</a></li>
        <li <?php if ($page=="about" ) { echo "class='active'"; } ?>><a href="about.php"><i class="material-icons left">info</i>About Me</a></li>
      </ul>
      <ul id="mobile-menu" class="right green lighten-1 side-nav">
        <li>
          <a href="assign.html" class="flow-text white-text">
            <i class="material-icons white-text flow-text left">play_for_work</i> Assignments
          </a>
        </li>
        <li>
          <a href="about.php" class="flow-text white-text">
            <i class="material-icons white-text flow-text left">info</i> About Me
          </a>
        </li>
      </ul>
    </div>
  </nav>
