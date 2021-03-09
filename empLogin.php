<?php
require('databaseConnection/DatabaseQueries.php');

  if (isset($_SESSION['user'])) {
    if(isLoggedIn()){
      header('location:');
    }elseif(isGuest()){
      header('location: guestHomepage.php');
    }elseif (isAgent()) {
      header('location: employeeAgent.php');
    }elseif (isSupport()) {
      header('location: dispatch.php');
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
  	<link href="stylesheets/allStyle.css" rel="stylesheet" type="text/css">
  	<script src="js/jquery-3.5.1.min.js"></script>
    <title>Employee Login</title>
  </head>
  <body style="
    background: url('img/bg.png') no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;">
    <div class="divLogin">
      <!-- Image and Title -->
      <div class="logoimg">
        <img src="img/logo.png" id="logotitle">
        <h3>ZAMSURECO-I EMPLOYEE</h3>
      </div>
        <?php display_error(); ?>
      <form class="formEmpLogin" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="text" placeholder="Username"name="username">
        <br>
        <input type="password" placeholder="Password" name="password">
        <br>
        <div class="divBtn" style="text-align: left;">
        <button type="submit" name="btnEmpLogin" class="mainBtn" style="width:100%">LOGIN</button>
          <!-- <button type="button" name="btnEmpForgotPass" class="mainBtn" style="float:right">Forgot Password</button> -->
        </div>
      </form>
      <p style="color:#666"><i>Contact your administrator for your account.</i></p>
    </div>
  </body>
</html>
