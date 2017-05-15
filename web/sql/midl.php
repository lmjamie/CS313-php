<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Database login</title>
</head>
<body>
  <?php
    $dbUrl = getenv('DATABASE_URL');

    $dbOpts = parse_url($dbUrl);
    echo "<p>URL:$dbUrl</p>\n\n";

    $dbHost = $dbOpts["host"];
    $dbPort = $dbOpts["port"];
    $dbUser = $dbOpts["user"];
    $dbPassword = $dbOpts["pass"];
    $dbName = ltrim($dbOpts["path"], '/');

    // echo "<p>pgsql:host=$dbHost;port=$dbPort;dbname=$dbName</p>\n\n";

    try {
      $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
      // $db = new PDO("pgsql:host=localhost;port=81;dbname=magicinventory;user=postgres;password=28ZAwras");
    }
    catch (PDOException $ex) {
      echo "<p>error: " . $ex->getMessage() . " </p>\n\n";
      die();
    }
  ?>
</body>
</html>
