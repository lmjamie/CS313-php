<?php
  $major_list = array(
    'CS' => "Computer Science",
    'WDD' => "Web Design and Development",
    'CIT' => "Computer Information Techonology",
    'CE' => "Computer Engineering"
  );
  $places_list = array(
    'NA' => "North America",
    'SA' => "South America",
    'EU' => "Europe",
    "AS" => "Asia",
    "AU" => "Australia",
    "AF" => "Africa",
    "AN" => "Antartica"
  );
  $name =  $_POST['name'];
  $email = $_POST['email'];
  $major = $_POST['major'];
  $places = $_POST['visited'];
  $comments = $_POST['comments'];

  echo
  "<h4>Name:</h4> $name
  <h4>E-mail:</h4> <a href=\"mailto:$email\">$email</a>
  <h4>Major:</h4> $major_list[$major]
  <h4>Places Visited:</h4>";
  foreach ($places as $p) {

    echo  "$places_list[$p], ";
  }
  echo "<h4>Comments:</h4> $comments";
 ?>
