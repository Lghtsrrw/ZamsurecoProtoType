<?php
include('databaseConnection/DatabaseQueries.php');

if (isLoggedIn()) {
    header('location: index.php');
}elseif (isGuest()) {
  header('location: guestHomepage.php');
} elseif(empty(isset($_SESSION['user']))){
  header('location: empLogin.php');
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type ="text/css"href="stylesheets/allStyle.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/employeeAgent.js"></script>
    <title>Employee</title>
  </head>

  <body style="background-color: #fcffed">
    <div id="divTicket">
      <h1>Employee Agent</h1>

      <?php if (isset($_SESSION['success'])) : ?>
    			<h5>
    				Logged in as:
    				<?php
    				echo $_SESSION['user']['Fname'] . ' ' . $_SESSION['user']['Lname'] . "<br>";
    				echo "ID: " . $_SESSION['user']['UserID'] . "<br>";
            echo "User Type: " . $_SESSION['user']['IDType'] . "<br>";
    				?>
    			</h5>
    	<?php endif ?>

      <button id = "btnComplaints" class="mainBtn">Complaint List</button>
      <button id = "btnDispatch" class="mainBtn" disabled>Dispatch</button>
      <button id = "btnCrew" class="mainBtn">Crew</button>
      <br>
    </div>

    <div class="modal" id="divTbl">
      <div class="modal-content animate" id="divIdTblComplaint" style="overflow-x:auto; width:100%;">
        <a id="btnBack" href="#" style="float:right;">BACK</a>

        <h3>Active Complaint</h3>
            <input type="text" name="" placeholder="Search" value="" class="cSearch" id="inSearch">
            <button type="button" name="btnSearch" id="btnIDSearch" class="mainBtn">Search</button>
        <label for="cmplntN" id="lblComplaintNo"></label>

        <table border="1" id="tblData">
          <tr>
            <th>Complaint No</th>
            <th>Nature of Complaint</th>
            <th>Description</th>
            <th>Region</th>
            <th>Province</th>
            <th>City/Mun</th>
            <th>Barangay</th>
          </tr>
          <?php fillComplaintTable(); ?>
        </table>

        <table border="0" id="tblSearch" style="display:none">
          <tr>
            <th>Complaint No</th>
            <th>Nature of Complaint</th>
            <th>Description</th>
            <th>Region</th>
            <th>Province</th>
            <th>City/Mun</th>
            <th>Barangay</th>
          </tr>
          <?php fillComplaintTable(); ?>
        </table>
      </div>
    </div>

  </body>

</html>
