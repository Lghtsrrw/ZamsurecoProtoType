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
    <link rel="stylesheet" type ="text/css" href="stylesheets/allStyle.css">
  	<script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/dispatch.js"></script>

    <title>Dispatch</title>
    <div style="width:100%; padding:10px">
    </div>
  </head>

  <body style="background-color: #fcffe8">

    <!-- Support Information -->
    <div id="divTicket">
      <!-- logout Button -->
      <div class="clscontainer">
          <button id = "btnLogout" class="mainBtn" style="width:auto; float:right; background-color: red;">Log-out</button>
      </div>
      <!-- title -->
      <div class="logoimg">
      <img src="img/logo.png" id="logotitle" style="height:200px; width:200px;">
      <h3>ZAMSURECO-I SUPPORT</h3>
      </div>
      <br>
      <div class="" style="text-align: right; width:100%">
        <label>User ID: <b><?php echo $_SESSION['user']['EmpID']; ?></b></label><br>
        <label>Support Name: <b><?php echo $_SESSION['user']['Fname'] . ' '. $_SESSION['user']['Lname']; ?></b></label>
      </div>
      <hr>
      <h3>Assigned Complaint</h3>
      <!-- List of Active Complaint -->
      <div id="tblAllData" style="overflow:auto">
        <table border="1" id="tblData">
          <tr>
            <th>Complaint No</th>
            <th>Description</th>
            <th>Nature of Complain</th>
            <th>Location</th>
            <th>Area Landmark</th>
            <th>Date Assigned</th>
            <th>Assignee</th>
          </tr>
          <?php fillAssignedComplaint($_SESSION['user']['EmpID']); ?>
        </table>
      </div>
    </div>
  </body>
</html>
