<?php
require('databaseConnection/DatabaseQueries.php');

  if(!empty($_GET['valempid']) && isset($_GET['valempid'])){
    echo loadEmployee();
	}

  function loadEmployee(){
    global $db;

    $the_value = $_GET['valempid'];
    $returnValue = "";
    $queryAddress = "SELECT * FROM employees where empid = '".$_GET['valempid']."' limit 1";
    $results = mysqli_query($db,$queryAddress) or die(mysqli_error());
    if(mysqli_num_rows($results) > 0)
    {
      while ($row = mysqli_fetch_assoc($results))
      {
        $returnValue = $row['empName'];
      }
    }else {
      $returnValue = "";
    }
    return $returnValue;
  }
 ?>
