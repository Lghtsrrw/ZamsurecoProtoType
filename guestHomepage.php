<?php
  include('databaseConnection/databaseConnection.php');

  if (empty(isset($_SESSION['user']))) {
  	header('location: signin.php');
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="ico" href="/css/master.css">
    <title>Welcome Guest</title>
    <h1>Welcome Guest!</h1>
  </head>
  <body>

  </body>
</html>
