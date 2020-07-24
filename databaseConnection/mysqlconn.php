<?php

  function connection{
    $dbUser = "root";
    $dbpw = "";
    $dbhost = "localhost"

    $conn = mysql_connect($dbhost, $dbUser, $dbpw);

    if(!conn){
      echo "<p>Connected</p>";
    }else {
      echo "<p>Error</p>";
    }
  }

 ?>
