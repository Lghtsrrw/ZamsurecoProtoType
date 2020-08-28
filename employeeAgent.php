<?php include('databaseConnection/databaseConnection.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link href="stylesheets/webStyle.css" rel="stylesheet" type="text/css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/employeeAgent.js"></script>
    <title>Employee</title>
  </head>

  <body style="background-color: #fcffed">
    <div id="divTicket">
      <h1>Employee Agent</h1>

      <button id = "btnComplaints" class="mainBtn">Complaint List</button>
      <button id = "btnInquireBill" class="mainBtn">Dispatch</button>
      <button id = "btnPayBills" class="mainBtn">Crew</button>
      <br>
      <div class="divTblComplaint" id="divIdTblComplaint" style="overflow-x:auto; width:80%; display:none;">
        <h3>Active Complaint</h3>
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
