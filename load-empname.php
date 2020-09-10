<?php

  include 'databaseConnection/DatabaseQueries.php';

  if(!empty(isset($_GET['valempid']))){
    $the_value = $_GET['valempid'];

    global $db;
    $returnValue = "";
    $queryAddress = "SELECT concat(fname,' ',mname,' ',lname)as'Name' FROM Employee where empid = '".$_GET['valempid']."' limit 1";
    $results = mysqli_query($db,$queryAddress) or die(mysqli_error());
    if(mysqli_num_rows($results) > 0)
    {
      while ($row = mysqli_fetch_assoc($results))
      {
        $returnValue = $row['Name'];
      }
    }
    echo $returnValue;
  }else {
    echo $_GET['valempid'];
  }
 ?>
