<?php
include("databaseConnection/databaseConnection.php");

  $_region = array();

  global $db;
  $sql = "SELECT regCode, regDesc FROM refRegion";
  $result = mysqli_query($db, $sql);
  while ($row = mysqli_fetch_array($result)) {
    array_push($_region, $row['regDesc']);
  }
  header('Content-Type: application/json');
  echo json_encode($_region);
?>
