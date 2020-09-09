<?php
    include("databaseConnection/DatabaseQueries.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type ="text/css"href="stylesheets/allStyle.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <title>Employee Registration</title>
  </head>
  <body style="background-color: #fcffed;">
    <div class="divLogin">
      <h1>Employee Registration Form</h1>
      <form class="frmEmpReg" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="empID"><b>Employee ID: <?php generateEmployeeID(); ?></b></label><br>
        <b><label for="">First Name</label></b><br>
        <input type="text" name="inputComplaint" ><br>
        <b><label for="">Middle Name</label></b><br>
        <input type="text" name="inputComplaint" ><br>
        <b><label for="">Last Name</label></b><br>
        <input type="text" name="inputComplaint" >
        <b><label for="">Area</label></b><br>
        <input type="text" name="inputComplaint" >
        <b><label for="">Department</label></b><br>
        <input type="text" name="inputComplaint" >
        <div class="divBtn" style="text-align: left;">
          <button type="submit" name="btnEmpLogin" class="mainBtn" style="width:100%">LOGIN</button>
          <!-- <button type="button" name="btnEmpForgotPass" class="mainBtn" style="float:right">Forgot Password</button> -->
        </div>
      </form>
      <p style="color:#666"><i>Contact your administrator for your account.</i></p>
    </div>
  </body>
</html>
