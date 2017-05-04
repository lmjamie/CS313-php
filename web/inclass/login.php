<?php session_start(); session_destroy(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
</head>
<body>
  <form action="authenticate.php" method="POST">
    <label for="user">Username:</label>
    <input type="text" name="username" id="user">
    <br>
    <label for="pass">Password:</label>
    <input type="password" name="password" id="pass">
    <br><br>
    <input type="submit" value="Login">
  </form>
</body>
</html>
