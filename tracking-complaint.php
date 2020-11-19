<?php
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
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/track-complaint.js"></script>
  </head>
  <body style="background-color: #fffbd9">

    <div id="divLogout" style="width:100%">
      <h5>
        <a id="btnBack" href="#">BACK</a>
      </h5>
    </div>

    <div id="container">
      <div class="imgcontainer">
        <img src="img/userprofile.png" alt="Avatar" class="avatar">
        <h3 style="color:navy; animate:">ZAMSURECO-I COMPLAINT TRACKER</h3>
      </div>

      <?php if(isset($_GET['TN'])) :?>
        <script type="text/javascript">
          displayComplainantInfo(<?php echo $_GET['TN']; ?>);
        </script>
        <div class="btnContainer" style="border: 1px solid slategrey; background-color: mintcream">
          <h4>User Information</h4>
          <table style="resize:auto; width:auto; border:none">
            <tr>
              <th style="text-align: right">Complainant name: </th>
              <td id="cname"></td>
            </tr>
            <tr>
              <th style="text-align: right">Agent Assignee: </th>
              <td id="aname"></td>
            </tr>
            <tr>
              <th style="text-align: right">Support Assigned: </th>
              <td id="sname"></td>
            </tr>
            <tr>
              <th style="text-align: right">Complainant contact: </th>
              <td id="ccont"></td>
            </tr>
            <tr>
              <th style="text-align: right">Complainant email: </th>
              <td id="cemail"></td>
            </tr>
          </table>

        </div>
        <hr>
        <div class="btnContainer" style="border: 1px solid slategrey; background-color: mintcream">
          <h4>Updates</h3>
          <table id="tblTrackingComplaint">
            <?php displayStatusfromTracking($_GET['TN']); ?>
          </table>
        </div>
      <?php elseif(!isset($_GET['TN']) || empty(isset($_GET['TN'])) ) :?>
        <script type="text/javascript"> window.location.href = 'signin.php'; </script>
      <?php endif ?>
    </div>
  </body>
</html>
