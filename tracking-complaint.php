<?php
require('databaseConnection/databaseConnectivity.php');
require('databaseConnection/DatabaseQueries.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tracking Complaint</title>
    <link rel="icon" type="image/x-ico" href="img/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="stylesheets/allStyle.css" rel="stylesheet" type="text/css">
    <script src="js/track-complaint.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
  </head>
  <body style="background-color: #fffbd9">
    <div class="container">
      <?php if(isset($_GET['TrackNo'])) :?>
        <div class="btnContainer">
          <h1 style="color:red; animate:">THIS PAGE IS UNDER-DEVELOPMENT. PLEASE BEAR WITH US. THANK YOU</h1>
        </div>
      <?php elseif(!isset($_GET['TrackNo']) || empty(isset($_GET['TrackNo'])) ) :?>
        <script type="text/javascript"> window.location.href = 'signin.php'; </script>
      <?php endif ?>
    </div>
  </body>
</html>
