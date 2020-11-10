<?php
require('databaseConnection/DatabaseQueries.php');

  if(!empty($_POST['complaintNo_tobesearch']) && isset($_POST['complaintNo_tobesearch'])){
    $searchValue = $_POST['complaintNo_tobesearch'];
    echo "<div id='div4Table'>";
    echo "<table border='1' id='tblData'>";
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
    echo "</div>";
  }else{
    echo "<div id='div4Table'>";
    echo "<table border='1' id='tblData'>";
    echo "<tr>";
    echo "<th>Complaint No</th>";
    echo "<th>Nature of Complaint</th>";
    echo "<th>Description</th>";
    echo "<th>Region</th>";
    echo "<th>Province</th>";
    echo "<th>City/Mun</th>";
    echo "<th>Barangay</th>";
    echo "</tr>";
    fillComplaintTable();
    echo "</table>";
    echo "</div>";
  }
 ?>
