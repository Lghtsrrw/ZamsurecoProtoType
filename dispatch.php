<?php
include('databaseConnection/DatabaseQueries.php');

if (isLoggedIn()) {
    header('location: index.php');
}elseif (isGuest()) {
  header('location: guestHomepage.php');
}elseif (isAgent()) {
	header('location: employeeAgent.php');
} elseif(empty(isset($_SESSION['user']))){
  header('location: empLogin.php');
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
  	<link href="stylesheets/allStyle.css" rel="stylesheet" type="text/css">
  	<script src="js/jquery-3.5.1.min.js"></script>

    <title>Dispatch</title>
    <div style="width:100%; padding:10px">
      <a href="index.php?logout='1'" style='color:red; float:right;'>Logout</a>
    </div>
    <div class="titleHeader">
      <span class="headerText"><img src="img/logo.png" id="logotitle" style="float:left; height: 100px; width: 100px"></span>
      <span class="headerText"><h1>DISPATCH</h1></span>
    </div>
  </head>

  <body style="background-color: #fcffe8">

    <!-- Support Information -->
    <div class="btnContainer">

    </div>
  </body>
</html>
