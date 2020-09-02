<?php
  include('databaseConnection/DatabaseQueries.php');
  $searchValue = $_POST['complaintNo_tobesearch'];

  echo "<table border='1' id='tblSearched' style='display:none'>";
  echo "<tr>";
  echo "<th>Complaint No</th>";
  echo "<th>Nature of Complaint</th>";
  echo "<th>Description</th>";
  echo "<th>Region</th>";
  echo "<th>Province</th>";
  echo "<th>City/Mun</th>";
  echo "<th>Barangay</th>";
  echo "</tr>";
  fillSearchTable($searchValue);
  echo "</table>";
 ?>
