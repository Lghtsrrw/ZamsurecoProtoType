<?php include('databaseConnection/databaseConnection.php'); ?>
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

      <button id = "btnComplaints" class="mainBtn">Complaint List</button>
      <button id = "btnDispatch" class="mainBtn" disabled>Dispatch</button>
      <button id = "btnCrew" class="mainBtn">Crew</button>
      <br>

    </div>

    <div class="modal" id="divTbl">

      <div class="modal-content animate" id="divIdTblComplaint" style="overflow-x:auto; width:100%;">
        <a id="btnBack" href="#">BACK</a>

        <h3>Active Complaint</h3>
        <label for="inSearchButton" style="clear:both; float:left;">Search</label>
        <input type="text" name="" value="">

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
      </div>
    </div>

  </body>

</html>
